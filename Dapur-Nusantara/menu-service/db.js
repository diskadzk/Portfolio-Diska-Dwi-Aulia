const mysql = require("mysql2");

const db = mysql.createConnection({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "menu_db"
});

db.connect(err => {
  if (err) {
    console.error("Menu DB error:", err);
  } else {
    console.log("Menu DB connected");
  }
});

module.exports = db;
