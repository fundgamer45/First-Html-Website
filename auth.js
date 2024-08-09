document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');
    const authLink = document.getElementById('authLink');

    // Function to check login status using a session variable
    const checkLoginStatus = async () => {
        try {
            // Fetch the login status
            const response = await fetch('check-login-status.php');
            const result = await response.json();

            console.log('Login Status:', result); // Debugging statement

            if (result.loggedIn) {
                if (authLink) {
                    authLink.textContent = 'Logout'; // Change text to 'Logout'
                    authLink.href = 'logout.php'; // Set link to logout
                }
            } else {
                if (authLink) {
                    authLink.textContent = 'Login'; // Change text to 'Login'
                    authLink.href = 'login.html'; // Set link to login
                }
            }
        } catch (error) {
            console.error('Error checking login status:', error);
        }
    };

    // Check login status when the page loads
    checkLoginStatus();

    if (signupForm) {
        signupForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(signupForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('signup.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();

                document.getElementById('signupMessage').textContent = result.message;
                if (result.success) {
                    window.location.href = 'login.html'; // Redirect on success
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();

                document.getElementById('loginMessage').textContent = result.message;
                if (result.success) {
                    window.location.href = 'index.html'; // Redirect on success
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    }
});
