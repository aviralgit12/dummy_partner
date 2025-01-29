<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SandBox Upload List</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @if(Session::has('auth_token'))
    @include('nav')
    <div class="container mx-auto px-4 py-8">
        <!-- Header with Create Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">SandBox Upload List</h1>
            <button onclick="openModal('create')"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Upload
            </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Points</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UUID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
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
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-150 "
                                >

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

        // Dummy data for demonstration
        const dummyUsers = [{
                id: 1,
                first_name: "John",
                last_name: "Doe",
                email: "john.doe@example.com",
                pet_points: 500,
                uuid: "550e8400-e29b-41d4-a716-446655440000"
            },
            {
                id: 2,
                first_name: "Jane",
                last_name: "Smith",
                email: "jane.smith@example.com",
                pet_points: 750,
                uuid: "7c9e6679-7425-40de-944b-e07fc1f90ae7"
            }
        ];

        async function fetchUsers() {
            const token = "<?php echo (session('auth_token')); ?>";
            const response = await fetch('/api/getUploadSandBox', {
                method: 'get',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
            });
            const data = await response.json();
            console.log(data.data);
            displayUsers(data.data);
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
                modalTitle.textContent = 'Upload';
                modalSubtitle.textContent = 'Enter user information';
                submitButton.textContent = 'Upload';
            
                // Clear form
                document.getElementById('userForm').reset();
            } else {
                modalTitle.textContent = 'Edit User';
                modalSubtitle.textContent = 'Update user information';
                submitButton.textContent = 'Save Changes';
                // Fill form with user data
                document.getElementById('userId').value = user.id;
                document.getElementById('firstName').value = user.first_name;
                document.getElementById('lastName').value = user.last_name;
                document.getElementById('email').value = user.email;
                document.getElementById('petPoints').value = user.pet_points;
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

        // Handle form submission
        document.getElementById('userForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const userData = {
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                pet_points: parseInt(document.getElementById('petPoints').value),
                uuid: document.getElementById('uuid').value
            };
            console.log(isCreateMode);
            //handle create api
            if (isCreateMode) {
                // Handle Create
                const token = "<?php echo (session('auth_token')); ?>";
                const response = await fetch('/api/uploadUserPetPoints', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    },
                    body: JSON.stringify(userData)
                });
                const data = await response.json();
                console.log(data.data);
                showNotification('User created successfully!');
            } else {
                // Handle Edit api
                const userId = document.getElementById('uuid').value;
                    const token = "<?php echo (session('auth_token')); ?>";
                const response = await fetch(`/api/editCustomer/${userId}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    },
                    body: JSON.stringify(userData)
                });
                const data = await response.json();
                // console.log(data.data);
                //     dummyUsers[userIndex] = {
                //         ...dummyUsers[userIndex],
                //         ...userData
                //     };
                    showNotification('User updated successfully!');
                
            }

            closeModal();
            fetchUsers();
        });

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg';
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