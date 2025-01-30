<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Log</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @if(Session::has('auth_token'))
    @include('nav')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Transaction Log</h1>
        </div>

        <!-- Enhanced Table Container -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Loading State -->
            <div id="loadingState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="mt-4 text-gray-600">Loading transactions...</p>
                </div>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p id="errorMessage" class="mt-4 text-lg text-gray-800 font-medium">Something went wrong</p>
                    <p id="errorDetails" class="mt-2 text-gray-600">Unable to fetch transaction data</p>
                    <button onclick="fetchTransactions()" 
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Try Again
                    </button>
                </div>
            </div>

            <!-- No Data State -->
            <div id="noDataState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="mt-4 text-lg text-gray-800 font-medium">No Transactions Found</p>
                    <p class="mt-2 text-gray-600">Transaction history will appear here</p>
                </div>
            </div>

            <!-- Data Table -->
            <table id="dataTable" class="hidden min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Points</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UUID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- View Details Modal -->
        <div id="viewModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-8 border-0 w-[800px] shadow-2xl rounded-xl bg-white">
                <!-- Modal Header -->
                <div class="border-b pb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-800">Transaction Details</h3>
                            <p class="text-gray-500 mt-1 text-sm" id="transactionId"></p>
                        </div>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
        
                <!-- Transaction Details -->
                <div class="mt-6 space-y-6">
                    <!-- Products List -->
                    <div>
                        
                        <div class="space-y-4" id="productsList">
                            <!-- Products will be populated here -->
                        </div>
                    </div>
        
                    <!-- Order Summary -->
                    <div class="border-t pt-4">
                       
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col ">
                                <span class="text-gray-600">Total Amount</span>
                                <span class="text-[12px]"> Including handling charges</span>
                            </div>
                            
                            <span class="text-xl font-semibold text-gray-900" id="totalAmount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show/hide states
        function showState(state) {
            const states = ['loadingState', 'errorState', 'noDataState', 'dataTable'];
            states.forEach(s => {
                document.getElementById(s).classList.add('hidden');
            });
            document.getElementById(state).classList.remove('hidden');
        }

        // Enhanced fetch transactions function with error handling
        async function fetchTransactions() {
            showState('loadingState');
            try {
                const token = "<?php echo (session('auth_token')); ?>";
                const response = await fetch('/api/getAllTransaction', {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (!data.data || data.data.length === 0) {
                    showState('noDataState');
                    return;
                }

                showState('dataTable');
                displayTransactions(data.data);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('errorMessage').textContent = 'Error Loading Transactions';
                document.getElementById('errorDetails').textContent = error.message || 'Unable to fetch transaction data';
                showState('errorState');
            }
        }

        // Display transactions in table
        function displayTransactions(transactions) {
    const tableBody = document.getElementById('userTableBody');
    tableBody.innerHTML = transactions.map(transaction => {
        let createdAt = new Date(transaction.created_at);
        let hours = createdAt.getHours();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        let formattedDate = `${createdAt.getFullYear()}-${String(createdAt.getMonth() + 1).padStart(2, '0')}-${String(createdAt.getDate()).padStart(2, '0')} ` +
            `${String(hours).padStart(2, '0')}:${String(createdAt.getMinutes()).padStart(2, '0')}:${String(createdAt.getSeconds()).padStart(2, '0')} ${ampm}`;

        // Calculate total amount for the row
        const totalAmount = transaction.transaction_data.reduce((sum, item) => 
            sum + (parseFloat(item.total_price) * item.quantity), 0);

        return `
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap">
                    ${transaction.first_name} ${transaction.last_name}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${transaction.email}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-green-600 font-medium">
                        ${totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">
                    ${transaction.uuid}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                    ${formattedDate}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button onclick='openModal(${JSON.stringify(transaction)})'
                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                        View Details
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

        // Modal functions
        function openModal(transaction) {
    const modal = document.getElementById('viewModal');
    const createdAt = new Date(transaction.created_at);
    
    // Format the date and time
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    };
    const formattedDate = createdAt.toLocaleDateString('en-US', options);

    // Show transaction ID and date
    document.getElementById('transactionId').textContent = 
        `${formattedDate}`;

    // Populate products list
    const productsContainer = document.getElementById('productsList');
    productsContainer.innerHTML = transaction.transaction_data.map(item => `
        <div class="bg-gray-50 rounded-lg px-4 py-2">
            <div class="flex justify-between items-start">
                <div class="space-y-1 flex-1">
                    <h5 class="font-medium text-gray-900">${item.product_title}</h5>
                    <p class="text-sm text-gray-500">Quantity: ${item.quantity}</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-900">${parseFloat(item.total_price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                </div>
            </div>
        </div>
    `).join('');

    // Calculate and display total amount
    const totalAmount = transaction.transaction_data.reduce((sum, item) => 
        sum + (parseFloat(item.total_price) * item.quantity), 0);
    document.getElementById('totalAmount').textContent = 
        `${totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

    modal.classList.remove('hidden');
}

        function closeModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transition = 'opacity 0.5s ease-in-out';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('viewModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Initial load
        fetchTransactions();
    </script>
    @else
    <script type="text/javascript">
        window.location.href = "/";
    </script>
    @endif
</body>
</html>