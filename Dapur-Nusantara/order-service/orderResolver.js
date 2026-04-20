const db = require("./db");
const axios = require("axios");

const getOrders = (req, res) => {
  const { user_id } = req.query;
  
  // Base query to join orders and items
  let query = `
    SELECT 
      o.id,
      o.id AS order_id,
      o.user_id,
      DATE_FORMAT(o.order_date, '%Y-%m-%d') AS order_date,
      o.total,
      o.order_type,
      o.pickup_number,
      oi.menu_id,
      oi.qty
    FROM orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
  `;
  
  const queryParams = [];
  if (user_id && user_id !== 'undefined' && user_id !== 'null') {
    query += " WHERE o.user_id = ?";
    queryParams.push(user_id);
  }
  
  query += " ORDER BY o.id DESC";

  db.query(query, queryParams, (err, results) => {
    if (err) {
      console.error("Database GetOrders Error:", err);
      return res.status(500).json({ error: err.message });
    }
    // Sanitize results: ensure IDs are strings for GraphQL
    const sanitized = results.map(r => ({
      ...r,
      id: String(r.id),
      order_id: String(r.order_id),
      user_id: String(r.user_id)
    }));
    res.json(sanitized);
  });
};

const createOrder = async (req, res) => {
  try {
    const { user_id, menu_id, qty, order_type = 'delivery' } = req.body;

    const menuServiceUrl = process.env.MENU_SERVICE_URL || "http://localhost:3003";
    const menuRes = await axios.get(
      `${menuServiceUrl}/menus/${menu_id}`
    );

    const menu = menuRes.data;
    const total = menu.price * qty;

    let pickupNumber = null;
    if (order_type === 'takeaway') {
      pickupNumber = 'TA-' + Math.floor(1000 + Math.random() * 9000);
    }

    db.query(
      "INSERT INTO orders (user_id, order_date, total, order_type, pickup_number) VALUES (?, CURDATE(), ?, ?, ?)",
      [user_id, total, order_type, pickupNumber],
      (err, orderResult) => {
        if (err) {
          console.error("Order insert error:", err);
          return res.status(500).json({ error: err.message });
        }

        const orderId = orderResult.insertId;

        db.query(
          "INSERT INTO order_items (order_id, menu_id, qty) VALUES (?, ?, ?)",
          [orderId, menu_id, qty],
          (err) => {
            if (err) {
              console.error("Order item insert error:", err);
              return res.status(500).json({ error: err.message });
            }

            res.status(201).json({
              order_id: orderId,
              user_id,
              menu: menu.name,
              price: menu.price,
              qty,
              total,
              order_type,
              pickup_number: pickupNumber
            });
          }
        );
      }
    );
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

module.exports = {
  getOrders,
  createOrder
};
