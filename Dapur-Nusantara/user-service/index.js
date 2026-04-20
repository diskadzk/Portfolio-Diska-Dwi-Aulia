const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");

const {
  getUsers,
  getUserById,
  createUser,
  loginUser,
} = require("./userResolver");

const app = express();
app.use(cors());
app.use(bodyParser.json());

app.get("/users", getUsers);
app.get("/users/:id", getUserById);
app.post("/users", createUser);
app.post("/login", loginUser);

app.listen(3001, () => {
  console.log("🚀 User Service running on port 3001");
});
