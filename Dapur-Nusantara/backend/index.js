import { ApolloServer } from "apollo-server";
import axios from "axios";
import typeDefs from "./schema/typeDefs.js";

const USER_SERVICE = process.env.USER_SERVICE_URL || "http://127.0.0.1:3001";
const MENU_SERVICE = process.env.MENU_SERVICE_URL || "http://127.0.0.1:3003";
const ORDER_SERVICE = process.env.ORDER_SERVICE_URL || "http://127.0.0.1:3002";

const resolvers = {
  Query: {
    getUsers: async () => {
      try {
        const response = await axios.get(`${USER_SERVICE}/users`);
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch users: ${error.message}`);
      }
    },

    getUser: async (_, { id }) => {
      try {
        const response = await axios.get(`${USER_SERVICE}/users/${id}`);
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch user: ${error.message}`);
      }
    },

    getMenus: async () => {
      try {
        const response = await axios.get(`${MENU_SERVICE}/menus`);
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch menus: ${error.message}`);
      }
    },

    getMenu: async (_, { id }) => {
      try {
        const response = await axios.get(`${MENU_SERVICE}/menus/${id}`);
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch menu: ${error.message}`);
      }
    },

    getOrders: async (_, { user_id }) => {
      try {
        const response = await axios.get(`${ORDER_SERVICE}/orders`, {
          params: { user_id }
        });
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch orders: ${error.message}`);
      }
    },

    getOrder: async (_, { id }) => {
      try {
        const response = await axios.get(`${ORDER_SERVICE}/orders/${id}`);
        return response.data;
      } catch (error) {
        throw new Error(`Failed to fetch order: ${error.message}`);
      }
    },
  },

  Mutation: {
    createUser: async (_, { name, email, password, address }) => {
      try {
        const response = await axios.post(`${USER_SERVICE}/users`, {
          name,
          email,
          password,
          address,
        });
        return response.data;
      } catch (error) {
        throw new Error(`Failed to create user: ${error.message}`);
      }
    },

    login: async (_, { email, password }) => {
      try {
        const response = await axios.post(`${USER_SERVICE}/login`, {
          email,
          password,
        });
        return response.data;
      } catch (error) {
        throw new Error(error.response?.data?.message || `Failed to login: ${error.message}`);
      }
    },

    createMenu: async (_, { name, price, image }) => {
      try {
        const response = await axios.post(`${MENU_SERVICE}/menus`, {
          name,
          price,
          image,
        });
        return response.data;
      } catch (error) {
        throw new Error(`Failed to create menu: ${error.message}`);
      }
    },

    updateMenu: async (_, { id, name, price, image }) => {
      try {
        const response = await axios.put(`${MENU_SERVICE}/menus/${id}`, {
          name,
          price,
          image,
        });
        return response.data;
      } catch (error) {
        throw new Error(`Failed to update menu: ${error.message}`);
      }
    },

    deleteMenu: async (_, { id }) => {
      try {
        const response = await axios.delete(`${MENU_SERVICE}/menus/${id}`);
        return response.data.message || "Menu deleted successfully";
      } catch (error) {
        throw new Error(`Failed to delete menu: ${error.message}`);
      }
    },

    createOrder: async (_, { user_id, menu_id, qty, order_type }) => {
      try {
        const response = await axios.post(`${ORDER_SERVICE}/orders`, {
          user_id,
          menu_id,
          qty,
          order_type
        });

        const orderData = response.data;
        return {
          id: orderData.order_id || orderData.id,
          order_id: orderData.order_id || orderData.id,
          user_id: orderData.user_id,
          menu_id: menu_id,
          qty: orderData.qty,
          total: orderData.total,
          order_type: orderData.order_type,
          pickup_number: orderData.pickup_number
        };
      } catch (error) {
        throw new Error(`Failed to create order: ${error.message}`);
      }
    },
  },

  Order: {
    user: async (parent) => {
      try {
        if (parent.user_id) {
          const response = await axios.get(`${USER_SERVICE}/users/${parent.user_id}`);
          return response.data;
        }
        return null;
      } catch (error) {
        return null;
      }
    },
    menu: async (parent) => {
      try {
        if (parent.menu_id) {
          const response = await axios.get(`${MENU_SERVICE}/menus/${parent.menu_id}`);
          return response.data;
        }
        return null;
      } catch (error) {
        return null;
      }
    },
  },
};


const server = new ApolloServer({
  typeDefs,
  resolvers,
  playground: true,
  introspection: true,
  cors: {
    origin: true,
    credentials: true,
  },
});

server.listen({ port: 4000, host: '0.0.0.0' }).then(({ url }) => {
  console.log(`🚀 GraphQL ready at ${url}`);
});
