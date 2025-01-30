<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer List</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @if(Session::has('auth_token'))
    @include('nav')
    <div class="container mx-auto px-4 py-8">
        <!-- Header with Create Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Customer List</h1>
            <button onclick="openModal('create')"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Create Customer
            </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Loading State -->
            <div id="loadingState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="mt-4 text-gray-600">Loading customers...</p>
                </div>
            </div>
        
            <!-- Error State -->
            <div id="errorState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p id="errorMessage" class="mt-4 text-lg text-gray-800 font-medium">Something went wrong</p>
                    <p id="errorDetails" class="mt-2 text-gray-600">Unable to fetch customer data</p>
                    <button onclick="fetchUsers()" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Try Again
                    </button>
                </div>
            </div>
        
            <!-- No Data State -->
            <div id="noDataState" class="hidden py-32">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-4 text-lg text-gray-800 font-medium">No Customers Found</p>
                    <p class="mt-2 text-gray-600">Get started by creating a new customer</p>
                    <button onclick="openModal('create')" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Customer
                    </button>
                </div>
            </div>
        
            <!-- Data Table -->
            <table id="dataTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Points</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UUID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Create/Edit User Modal -->
        <div id="userModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-8 border-0 w-[500px] shadow-2xl rounded-xl bg-white">
                <!-- Modal Header -->
                <div class="border-b pb-4 mb-6">
                    <h3 class="text-2xl font-semibold text-gray-800" id="modalTitle">Edit User</h3>
                    <p class="text-gray-500 mt-1 text-sm" id="modalSubtitle">Update user information below</p>
                </div>

                <!-- Form -->
                <form id="userForm" class="space-y-5">
                    <input type="hidden" id="userId">

                    <!-- Name Fields Group -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="firstName" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="lastName" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <input type="email" id="email" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Pet Points Field -->
                    <div>
                        <label for="petPoints" class="block text-sm font-medium text-gray-700 mb-1">Pet Points</label>
                        <div class="relative">
                            <input type="number" id="petPoints" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- UUID Field -->
                    <div>
                        <label for="uuid" class="block text-sm font-medium text-gray-700 mb-1">UUID</label>
                        <div class="flex gap-2">
                            <input type="text" id="uuid" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 bg-gray-50"
                                readonly>
                            <button id="generate_uuid" type="button" onclick="generateUUID()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 transition duration-150">
                                Generate
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 mt-6 border-t">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition duration-150">
                            Cancel
                        </button>
                        <button type="submit" id="submitButton"
                            class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Configuration
        const MAIN_WEBSITE_URL = "{{ config('app.url') }}/api/referralLink";
        let isCreateMode = false;

        function showState(state) {
        const states = ['loadingState', 'errorState', 'noDataState', 'dataTable'];
        states.forEach(s => {
            document.getElementById(s).classList.add('hidden');
        });
        document.getElementById(state).classList.remove('hidden');
    }
      

    async function fetchUsers() {
        showState('loadingState');
        try {
            const token = "<?php echo (session('auth_token')); ?>";
            const response = await fetch('/api/getAllCustomer', {
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
            displayUsers(data.data);
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('errorMessage').textContent = 'Error Loading Data';
            document.getElementById('errorDetails').textContent = error.message || 'Unable to fetch customer data';
            showState('errorState');
        }
    }

        // Display users in table
        function displayUsers(users) {
            const tableBody = document.getElementById('userTableBody');
            tableBody.innerHTML = users.map(user => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${user.first_name} ${user.last_name}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${user.email}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${user.pet_point.toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${user.uuid}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button onclick='openModal("edit", ${JSON.stringify(user).replace(/'/g, "&apos;")})' 
                            class="text-indigo-600 hover:text-indigo-900 mr-4">
                            Edit
                        </button>
                        <button onclick="redirectToShop('${user.uuid}')"
                            class="text-green-600 hover:text-green-900">
                            Shop Now
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Modal functions
        function openModal(mode, user = null) {
            isCreateMode = mode === 'create';
            const modal = document.getElementById('userModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalSubtitle = document.getElementById('modalSubtitle');
            const submitButton = document.getElementById('submitButton');

            if (isCreateMode) {
                modalTitle.textContent = 'Create User';
                modalSubtitle.textContent = 'Enter new user information';
                submitButton.textContent = 'Create User';
                document.getElementById('generate_uuid').hidden=false;
                // Clear form
                document.getElementById('userForm').reset();
                // Generate new UUID
                generateUUID();
            } else {
                modalTitle.textContent = 'Edit User';
                modalSubtitle.textContent = 'Update user information';
                submitButton.textContent = 'Save Changes';
                document.getElementById('generate_uuid').hidden=true;
                // Fill form with user data
                document.getElementById('userId').value = user.id;
                document.getElementById('firstName').value = user.first_name;
                document.getElementById('lastName').value = user.last_name;
                document.getElementById('email').value = user.email;
                document.getElementById('petPoints').value = user.pet_point;
                document.getElementById('uuid').value = user.uuid;
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userForm').reset();
        }

        function generateUUID() {
            const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0;
                const v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
            document.getElementById('uuid').value = uuid;
            return uuid;
        }

        document.getElementById('userForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitButton = document.getElementById('submitButton');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';

        try {
            const userData = {
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                pet_points: parseInt(document.getElementById('petPoints').value),
                uuid: document.getElementById('uuid').value
            };

            const token = "<?php echo (session('auth_token')); ?>";
            const endpoint = isCreateMode ? '/api/createCustomer' : `/api/editCustomer/${userData.uuid}`;
            
            const response = await fetch(endpoint, {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify(userData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to process request');
            }

            const data = await response.json();
            showNotification(isCreateMode ? 'Customer created successfully!' : 'Customer updated successfully!', 'success');
            closeModal();
            fetchUsers();
        } catch (error) {
            console.error('Error:', error);
            showNotification(error.message || 'An error occurred while processing your request', 'error');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    });


    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.textContent = message;
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded shadow-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

        // Shop now redirect function
        function redirectToShop(uuid) {
            window.open(`${MAIN_WEBSITE_URL}/${uuid}`, '_blank');
        }

        // Initial load
        fetchUsers();

        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
    @else
    <script type="text/javascript">
        window.location.href = "/"; 
        // Redirect to the login page
    </script>
    @endif