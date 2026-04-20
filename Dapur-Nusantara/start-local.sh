echo "🚀 Starting all services locally..."
echo ""

echo "📦 Starting User Service on port 3001..."
cd user-service
node index.js &
USER_PID=$!
cd ..

echo "📦 Starting Order Service on port 3002..."
cd order-service
node index.js &
ORDER_PID=$!
cd ..

echo "📦 Starting Menu Service on port 3003..."
cd menu-service
node index.js &
MENU_PID=$!
cd ..

echo "📦 Starting Backend GraphQL on port 4000..."
cd backend
node index.js &
BACKEND_PID=$!
cd ..

sleep 3

echo "📦 Starting Frontend on port 8080..."
cd food-delivery-frontend
npm run dev &
FRONTEND_PID=$!
cd ..

echo ""
echo "✅ All services started!"
echo ""
echo "📍 Services running on:"
echo "   - Frontend: http://localhost:8080"
echo "   - GraphQL: http://localhost:4000/graphql"
echo "   - User Service: http://localhost:3001"
echo "   - Order Service: http://localhost:3002"
echo "   - Menu Service: http://localhost:3003"
echo ""
echo "Press Ctrl+C to stop all services"

cleanup() {
    echo ""
    echo "🛑 Stopping all services..."
    kill $USER_PID $ORDER_PID $MENU_PID $BACKEND_PID $FRONTEND_PID 2>/dev/null
    exit
}

trap cleanup SIGINT SIGTERM

wait

