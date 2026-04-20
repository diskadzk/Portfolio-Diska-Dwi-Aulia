import { gql } from "apollo-server";

const typeDefs = gql`
  type User {
    id: ID!
    name: String
    email: String
    address: String
  }

  type Menu {
    id: ID!
    name: String!
    price: Int!
    image: String
  }

  type OrderItem {
    menu_id: ID!
    qty: Int!
    menu: Menu
  }

  type Order {
    id: ID!
    order_id: ID
    user_id: ID!
    order_date: String
    total: Int
    order_type: String
    pickup_number: String
    menu_id: ID
    qty: Int
    items: [OrderItem]
    user: User
    menu: Menu
  }

  type AuthResponse {
    message: String!
    id: ID
    name: String
    email: String
    address: String
  }

  type Query {
    # User queries
    getUsers: [User]
    getUser(id: ID!): User
    
    # Menu queries
    getMenus: [Menu]
    getMenu(id: ID!): Menu
    
    # Order queries
    getOrders(user_id: ID): [Order]
    getOrder(id: ID!): Order
  }

  type Mutation {
    # User mutations
    createUser(
      name: String!
      email: String!
      password: String!
      address: String
    ): User
    
    login(
      email: String!
      password: String!
    ): AuthResponse
    
    # Menu mutations
    createMenu(
      name: String!
      price: Int!
      image: String
    ): Menu
    
    updateMenu(
      id: ID!
      name: String
      price: Int
      image: String
    ): Menu
    
    deleteMenu(id: ID!): String
    
    # Order mutations
    createOrder(
      user_id: ID!
      menu_id: ID!
      qty: Int!
      order_type: String
    ): Order
    
    addOrder(
      name: String
      address: String
      item: String
      qty: Int
      total: Int
      restaurant: String
    ): Order
  }
`;

export default typeDefs;
