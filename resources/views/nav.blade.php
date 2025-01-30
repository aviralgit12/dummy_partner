<style>
    /* Basic reset with improved box-sizing */
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Enhanced navbar styling */
    .navbar {
        background-color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .nav-links {
        list-style-type: none;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 2rem;
        max-width: 1440px;
        margin: 0 auto;
    }

    .nav-links li {
        position: relative;
    }

    .nav-links a {
        text-decoration: none;
        color: #4B5563;
        font-size: 0.95rem;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
        display: inline-block;
    }

    .nav-links a:hover {
        color: #4F46E5;
        background-color: #F3F4F6;
    }

    /* Active link styling */
    .nav-links a.active {
        color: #4F46E5;
        background-color: #EEF2FF;
        font-weight: 600;
    }

    .nav-links a.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 2px;
        background-color: #4F46E5;
        border-radius: 2px;
    }

    /* Logout button special styling */
    .nav-links li:last-child a {
        color: #DC2626;
        font-weight: 500;
    }

    .nav-links li:last-child a:hover {
        background-color: #FEE2E2;
        color: #B91C1C;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .nav-links {
            gap: 1rem;
        }

        .nav-links a {
            font-size: 0.875rem;
            padding: 0.375rem 0.5rem;
        }
    }
</style>

<nav class="navbar">
    <ul class="nav-links">
        <li>
            <a href="all-users" class="{{ request()->is('all-users') ? 'active' : '' }}">
                Partner
            </a>
        </li>
        <li>
            <a href="uploadPetPoints" class="{{ request()->is('uploadPetPoints') ? 'active' : '' }}">
                API Upload
            </a>
        </li>
        <li>
            <a href="transaction" class="{{ request()->is('transaction') ? 'active' : '' }}">
                Transaction
            </a>
        </li>
        <li>
            <a href="logout">
                Logout
            </a>
        </li>
    </ul>
</nav>

<!-- Optional JavaScript for smooth scroll behavior -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    });
</script>