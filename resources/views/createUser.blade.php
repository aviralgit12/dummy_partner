<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create New User
                </h2>
            </div>
            <form class="mt-8 space-y-6" id="createUserForm">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input id="first_name" name="first_name" type="text" required 
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required 
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required 
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <div>
                        <label for="pet_points" class="block text-sm font-medium text-gray-700">Pet Points</label>
                        <input id="pet_points" name="pet_points" type="number" required 
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>

                    <div>
                        <label for="uuid" class="block text-sm font-medium text-gray-700">UUID</label>
                        <div class="flex gap-2">
                            <input id="uuid" name="uuid" type="text" required 
                                class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <button type="button" onclick="generateAndSetUUID()" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create User
                    </button>
                </div>
            </form>

            <!-- Success/Error Messages -->
            <div id="successMessage" class="mt-4 text-green-600 text-sm hidden"></div>
            <div id="errorMessage" class="mt-4 text-red-600 text-sm hidden"></div>
        </div>
    </div>

    <script>
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function generateAndSetUUID() {
            document.getElementById('uuid').value = generateUUID();
        }

        // Generate UUID when page loads
        window.addEventListener('load', generateAndSetUUID);

        document.getElementById('createUserForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                pet_points: document.getElementById('pet_points').value,
                uuid: document.getElementById('uuid').value
            };

            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            try {
                const response = await fetch('/api/create-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    // Show success message
                    successMessage.textContent = 'User created successfully!';
                    successMessage.classList.remove('hidden');
                    errorMessage.classList.add('hidden');
                    
                    // Optional: Reset form
                    document.getElementById('createUserForm').reset();
                    
                    // Optional: Redirect after success
                    // window.location.href = '/success-page';
                } else {
                    // Show error message
                    errorMessage.textContent = data.message || 'Failed to create user. Please try again.';
                    errorMessage.classList.remove('hidden');
                    successMessage.classList.add('hidden');
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred. Please try again later.';
                errorMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
                console.error('Error creating user:', error);
            }
        });

      
    </script>
</body>
</html>