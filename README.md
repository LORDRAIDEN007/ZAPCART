The Smart Cart revolutionizes the traditional shopping experience by automating checkout processes in grocery stores and malls. This innovation features a Raspberry Pi-powered device with a 10.1-inch Touch Screen LCD that displays real-time updates on item weight, total cost, and quantity with a well-designed UI. Integrated with RFID readers, the cart detects products instantly as they are added or removed, eliminating the need for manual scanning at checkout. Customers can complete purchases effortlessly via QR code. The cart includes a Type-C port for efficient device charging. The accompanying admin software empowers store managers to monitor active carts, track purchases, and optimize inventory. The system also captures valuable customer data, enabling personalized marketing and enhancing overall store efficiency.

Work Flow: 
1. Initialization & User Authentication
• The customer selects a Smart Cart and powers it on.
• A welcome screen appears and then redirects to the home page.

2. Product Scanning & Cart Interaction
• As the customer adds a product to the cart, the RFID reader automatically detects the item’s tag.
• The system displays the product name, price and total bill on the 10.1-inch Touch Screen LCD.
• If a product is removed, the system instantly updates the cart, adjusting the total price and accordingly.
• A built-in Load Cell ensures that the scanned product weight matches expectations, preventing theft or errors.

3. Cart Navigation & Shopping Assistance
• The touchscreen interface provides an interactive shopping experience, including:
• A search function to locate items in the store.
• A recommended product section based on past purchases or current offers.

4. Checkout Process
• Once the shopping is complete, the user proceeds to checkout via the touchscreen.
• A QR code for payment is generated, allowing customers to pay via mobile wallets, UPI, or credit/debit cards.
• After payment confirmation, the cart screen displays a digital receipt, and a soft copy is sent via email or SMS.

5. Store Management & Admin Monitoring
• Store managers can access a real-time dashboard displaying:
• The number of active Smart Carts in the store.
• Live tracking of products added/removed from carts.
• Customer purchase trends for inventory management and personalized marketing.
• The collected data can help optimize stock levels and improve store operations.

6. Exit & Security Check
• A store security checkpoint verifies that all scanned products match the cart’s content using RFID tracking.
• Once cleared, the customer exits without needing a traditional checkout counter.

## Features
- User-friendly interface
- Secure payment processing
- Inventory management
- Subscription plans
- Real-time analytics

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/LORDRAIDEN007/ZAPCART.git
   ```
2. Navigate to the project directory:
   ```bash
   cd zapcart2.0
   ```
3. Set up the database using the provided SQL scripts.
4. Configure the database connection in `helpers/init_conn_db.php`.

## Usage
- Access the admin panel at `/zapcart_admin`.
- Access the store owner panel at `/user_admin`.
- Access zapcart disply at `/screen`.
- Manage products, subscriptions, and transactions.
- View analytics and reports.

## Contributing
We welcome contributions! Please fork the repository and submit a pull request.

## License
This project is licensed under the MIT License.
