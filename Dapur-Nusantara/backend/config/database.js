import mongoose from "mongoose";

const connectDB = async () => {
  try {
    await mongoose.connect("mongodb://127.0.0.1:27017/uts-iae");
    console.log("Database connected");
  } catch (error) {
    console.error("Database connection failed", error);
  }
};

export default connectDB;