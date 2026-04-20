const mysql = require("mysql2");

const db = mysql.createConnection({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "order_db"
});

db.connect(err => {
  if (err) {
    console.error("Order DB error:", err);
  } else {
    console.log("Order DB connected");
    // Ensure tables exist
    db.query(`
      CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        order_date DATE NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        order_type VARCHAR(20) DEFAULT 'delivery',
        pickup_number VARCHAR(10) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `);
    db.query(`
      CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        menu_id INT NOT NULL,
        qty INT NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
      )
    `);
    console.log("Database schema checked/updated");
  }
});

module.exports = db;
