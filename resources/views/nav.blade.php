
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar styling */
        .navbar {
            background-color: white;
           
            padding: 10px;
        }

        .nav-links {
            list-style-type: none;
            display: flex;
            justify-content: right;
            margin-right: 50px;
        }

        .nav-links li {
            padding: 10px;
        }

        .nav-links a {
            text-decoration: none;
            color: black;
            font-size: 14px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #4CAF50;
        }
    </style>

    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="all-users">Partner</a></li>
            <li><a href="uploadPetPoints">API Upload</a></li>
            <li><a href="transaction">Transaction</a></li>
            <li><a href="logout">Logout</a></li>
        </ul>
    </nav>
