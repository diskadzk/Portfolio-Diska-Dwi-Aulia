const db = require("./db");

const getUsers = (req, res) => {
  const query = "SELECT id, name, email, address FROM users";

  db.query(query, (err, results) => {
    if (err) {
      console.error("Database Error:", err);
      return res.status(500).json({ error: "Internal Server Error" });
    }
    res.status(200).json(results);
  });
};

const getUserById = (req, res) => {
  const { id } = req.params;
  const query = "SELECT id, name, email, address FROM users WHERE id = ?";

  db.query(query, [id], (err, results) => {
    if (err) {
      console.error("Database Error:", err);
      return res.status(500).json({ error: "Internal Server Error" });
    }

    if (results.length === 0) {
      return res.status(404).json({ message: "User not found" });
    }

    res.status(200).json(results[0]);
  });
};

const createUser = (req, res) => {
  const { name, email, password, address } = req.body;

  if (!name || !email) {
    return res.status(400).json({ message: "Name and Email are required" });
  }

  const query = "INSERT INTO users (name, email, password, address) VALUES (?, ?, ?, ?)";
  const values = [name, email, password || "default123", address || ""];

  db.query(query, values, (err, result) => {
    if (err) {
      console.error("Database Error:", err);
      return res.status(500).json({ error: "Failed to create user" });
    }

    res.status(201).json({
      message: "User created successfully",
      id: result.insertId,
      name,
      email,
      address: address || "",
    });
  });
};

const loginUser = (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) {
    return res.status(400).json({ message: "Email and Password are required" });
  }

  const query = "SELECT id, name, email, address FROM users WHERE email = ? AND password = ?";

  db.query(query, [email, password], (err, results) => {
    if (err) {
      console.error("Database Error:", err);
      return res.status(500).json({ error: "Internal Server Error" });
    }

    if (results.length === 0) {
      return res.status(401).json({ message: "Invalid email or password" });
    }

    res.status(200).json({
      message: "Login successful",
      id: results[0].id,
      name: results[0].name,
      email: results[0].email,
      address: results[0].address || "",
    });
  });
};

module.exports = {
  getUsers,
  getUserById,
  createUser,
  loginUser,
};