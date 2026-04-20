const db = require("./db");

db.query(
  "ALTER TABLE orders ADD COLUMN order_type VARCHAR(20) DEFAULT 'delivery', ADD COLUMN pickup_number VARCHAR(10) DEFAULT NULL;",
  (err) => {
    if (err && err.code !== 'ER_DUP_FIELDNAME') {
      console.error("Failed to alter table:", err);
    } else {
      console.log("Database altered successfully");
    }
    process.exit();
  }
);
