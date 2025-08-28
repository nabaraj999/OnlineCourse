<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon) }}" alt="FinHedge Logo"
        class="h-auto w-auto">
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
     <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-frontend-header />

    <main>
        {{ $slot }}
    </main>


</body>
  <div id="support-widget">
        <!-- Floating Button -->
        <button id="support-button" class="fixed bottom-6 right-6 w-16 h-16 rounded-full bg-primary shadow-2xl flex items-center justify-center text-white text-2xl animate-float z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </button>

        <!-- Modal Overlay -->
        <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden transition-opacity duration-300">
            <div class="flex items-center justify-center min-h-screen p-4">
                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-hidden flex flex-col animate-fade-in">
                    <!-- Close Button -->
                    <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 bg-white rounded-full p-1 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Tabs -->
                    <div class="flex border-b">
                        <button id="chat-tab" class="flex-1 py-4 px-6 text-center font-semibold text-primary border-b-2 border-primary bg-light">
                            💬 Chat with AI
                        </button>
                        <button id="ticket-tab" class="flex-1 py-4 px-6 text-center font-semibold text-gray-500">
                            🎫 Generate Ticket
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div class="flex-1 overflow-y-auto">
                        <!-- Chat with AI Tab -->
                        <div id="chat-content" class="p-4">
                            <h3 class="text-xl font-bold text-center mb-4">AI Support Assistant 🤖</h3>

                            <!-- Chat Messages -->
                            <div id="chat-messages" class="space-y-4 mb-4 max-h-80 overflow-y-auto p-2">
                                <!-- AI Message -->
                                <div class="flex items-start space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white">🤖</div>
                                    <div class="bg-primary text-white rounded-lg p-3 max-w-xs">
                                        <p>Hello! I'm your AI assistant. How can I help you with your course today?</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Input Area -->
                            <div class="border-t pt-4">
                                <div class="flex space-x-2">
                                    <textarea id="message-input" class="flex-1 border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Type your question…" rows="2"></textarea>
                                    <button id="send-message" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg flex items-center gap-2 self-end">
                                        <span>Send</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Ticket Tab -->
                        <div id="ticket-content" class="p-4 hidden">
                            <h3 class="text-xl font-bold text-center mb-6">Create Support Ticket 🎫</h3>

                            <!-- Ticket Form -->
                            <form id="ticket-form" action="{{ route('tickets.store') }}" method="POST" class="space-y-4">
    @csrf
    <div class="grid grid-cols-1 gap-4">
        <!-- Full Name -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-user"></i>
            </div>
            <input type="text" name="name"
                   class="pl-10 w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm"
                   placeholder="Full Name" required>
        </div>

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-envelope"></i>
            </div>
            <input type="email" name="email"
                   class="pl-10 w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm"
                   placeholder="Email Address" required>
        </div>

        <!-- Phone Number -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="fas fa-phone"></i>
            </div>
            <input type="tel" name="phone"
                   class="pl-10 w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm"
                   placeholder="Phone Number">
        </div>

        <!-- Problem/Issue -->
        <div class="relative">
            <div class="absolute top-3 left-3 text-gray-400 pointer-events-none">
                <i class="fas fa-comment-dots"></i>
            </div>
            <textarea name="issue" rows="4"
                      class="pl-10 w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm"
                      placeholder="Describe your problem/issue" required></textarea>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="w-full bg-secondary text-white font-bold px-6 py-3 rounded-xl shadow-md hover:scale-105 hover:bg-opacity-90 transition transform duration-200 flex items-center justify-center gap-2">
        <i class="fas fa-paper-plane"></i> Submit Ticket
    </button>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1E3A8A',
                    secondary: '#F59E0B',
                    light: '#F8FAFC'
                },
                fontFamily: {
                    raleway: ['Raleway', 'sans-serif']
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'fade-in': 'fadeIn 1.5s ease-in-out'
                },
                keyframes: {
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' }
                    },
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' }
                    }
                }
            }
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const supportButton = document.getElementById('support-button');
        const modalOverlay = document.getElementById('modal-overlay');
        const closeModal = document.getElementById('close-modal');
        const chatTab = document.getElementById('chat-tab');
        const ticketTab = document.getElementById('ticket-tab');
        const chatContent = document.getElementById('chat-content');
        const ticketContent = document.getElementById('ticket-content');
        const messageInput = document.getElementById('message-input');
        const sendMessage = document.getElementById('send-message');
        const ticketForm = document.getElementById('ticket-form');
        const chatMessages = document.getElementById('chat-messages');

        // Open modal when support button is clicked
        supportButton.addEventListener('click', function() {
            modalOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        // Close modal when close button is clicked
        closeModal.addEventListener('click', function() {
            modalOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Close modal when clicking outside of modal content
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                modalOverlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Switch to chat tab
        chatTab.addEventListener('click', function() {
            chatTab.classList.add('text-primary', 'border-primary', 'bg-light');
            chatTab.classList.remove('text-gray-500');
            ticketTab.classList.remove('text-primary', 'border-primary', 'bg-light');
            ticketTab.classList.add('text-gray-500');
            chatContent.classList.remove('hidden');
            ticketContent.classList.add('hidden');
        });

        // Switch to ticket tab
        ticketTab.addEventListener('click', function() {
            ticketTab.classList.add('text-primary', 'border-primary', 'bg-light');
            ticketTab.classList.remove('text-gray-500');
            chatTab.classList.remove('text-primary', 'border-primary', 'bg-light');
            chatTab.classList.add('text-gray-500');
            ticketContent.classList.remove('hidden');
            chatContent.classList.add('hidden');
        });

        // Send message in chat
        sendMessage.addEventListener('click', function() {
            const message = messageInput.value.trim();
            if (message) {
                addMessage(message, 'user');
                messageInput.value = '';

                setTimeout(() => {
                    let response = "I'm sorry, I didn't understand that. Can you please provide more details?";

                    if (message.toLowerCase().includes('access') || message.toLowerCase().includes('material')) {
                        response = "For access issues, please try clearing your browser cache or using a different browser. If the problem persists, contact technical support.";
                    } else if (message.toLowerCase().includes('video') || message.toLowerCase().includes('play')) {
                        response = "Video playback issues are often related to internet connection. Try lowering the video quality or downloading the video for offline viewing.";
                    } else if (message.toLowerCase().includes('certificate') || message.toLowerCase().includes('complete')) {
                        response = "Certificates are automatically generated when you complete all course requirements. Please allow up to 24 hours for certificate generation after completion.";
                    }

                    addMessage(response, 'ai');
                }, 1000);
            }
        });

        // Allow sending message with Enter key
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage.click();
            }
        });

        // Handle ticket form submission
        ticketForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(ticketForm);
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found.');
                alert('CSRF token missing. Please refresh the page.');
                return;
            }

            // Log form data for debugging
            for (let pair of formData.entries()) {
                console.log('Form data:', pair[0] + ': ' + pair[1]);
            }

            try {
                const response = await fetch('{{ route('tickets.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                console.log('Server response:', response); // Log full response object

                if (!response.ok) {
                    const errorText = await response.text();
                    let errorMessage = `HTTP error! status: ${response.status}`;
                    if (response.status === 419) {
                        errorMessage += ' - Possible CSRF token mismatch. Refresh the page and try again.';
                    } else if (response.status === 422) {
                        errorMessage += ' - Validation error: ' + errorText;
                    } else if (response.status === 500) {
                        errorMessage += ' - Server error. Check logs.';
                    } else {
                        errorMessage += ' - ' + errorText;
                    }
                    throw new Error(errorMessage);
                }

                const data = await response.json();
                // Show success notification instead of alert
                showSuccessNotification(data.message);
                ticketForm.reset();
                chatTab.click();
            } catch (error) {
                console.error('Ticket submission error:', error);
                alert(`Failed to submit ticket. Error: ${error.message}. Check the console for details.`);
            }
        });

        // Helper function to add messages to chat
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('flex', 'items-start', 'space-x-2');

            if (sender === 'user') {
                messageDiv.classList.add('justify-end');
                messageDiv.innerHTML = `
                    <div class="bg-secondary text-white rounded-lg p-3 max-w-xs">
                        <p>${text}</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">👤</div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white">🤖</div>
                    <div class="bg-primary text-white rounded-lg p-3 max-w-xs">
                        <p>${text}</p>
                    </div>
                `;
            }

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Function to show success notification
        function showSuccessNotification(message) {
            const notification = document.createElement('div');
            notification.classList.add('fixed', 'bottom-6', 'right-6', 'bg-green-500', 'text-white', 'px-4', 'py-2', 'rounded-lg', 'shadow-lg', 'transition-opacity', 'duration-300', 'z-50');
            notification.textContent = message;
            document.body.appendChild(notification);

            // Auto-remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('opacity-0');
                setTimeout(() => {
                    notification.remove();
                }, 300); // Match transition duration
            }, 3000);
        }
    });
</script>

<style type="text/tailwindcss">
    @layer utilities {
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* ✅ Navbar hover effect */
        .nav-link {
            @apply text-gray-700 border-b-2 border-transparent transition duration-300;
        }
        .nav-link:hover {
            @apply text-secondary border-secondary font-semibold;
        }
        .nav-link-active {
            @apply text-primary font-semibold border-b-2 border-secondary;
        }
    }
</style>

</html>
