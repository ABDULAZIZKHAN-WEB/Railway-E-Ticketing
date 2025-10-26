// Bangladesh Railway E-Ticketing Custom JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Railway App
    initializeRailwayApp();
    
    // Form Enhancements
    enhanceForms();
    
    // Search Form Enhancements
    enhanceSearchForm();
    
    // Seat Selection
    initializeSeatSelection();
    
    // Notifications
    initializeNotifications();
    
    // Loading States - Disabled to allow normal form submission
    // initializeLoadingStates();
    
    // Animation Observers
    initializeAnimations();
});

function initializeRailwayApp() {
    console.log('🚄 Bangladesh Railway E-Ticketing System Initialized');
    
    // Add train icon animation to navbar
    const navbarBrand = document.querySelector('.navbar-railway a');
    if (navbarBrand) {
        const trainIcon = navbarBrand.querySelector('🚄');
        if (trainIcon) {
            trainIcon.classList.add('train-icon');
        }
    }
}

function enhanceForms() {
    // Add floating labels effect
    const inputs = document.querySelectorAll('.input-railway');
    if (inputs.length > 0) {
        inputs.forEach(input => {
            // Add focus/blur effects
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
            
            // Real-time validation
            input.addEventListener('input', function() {
                validateField(this);
            });
        });
    }
    
    // Remove automatic loading states - let forms submit normally
    console.log('Form enhancements initialized');
}

function enhanceSearchForm() {
    const searchForm = document.querySelector('.search-form-railway form');
    if (!searchForm) return;
    
    const fromStation = searchForm.querySelector('select[name="from_station"]');
    const toStation = searchForm.querySelector('select[name="to_station"]');
    const journeyDate = searchForm.querySelector('input[name="journey_date"]');
    
    // Swap stations functionality
    const swapBtn = document.createElement('button');
    swapBtn.type = 'button';
    swapBtn.innerHTML = '🔄';
    swapBtn.className = 'btn-railway-outline px-3 py-2 ml-2';
    swapBtn.title = 'Swap Stations';
    
    if (fromStation && toStation) {
        fromStation.parentElement.appendChild(swapBtn);
        
        swapBtn.addEventListener('click', function() {
            const fromValue = fromStation.value;
            const toValue = toStation.value;
            
            fromStation.value = toValue;
            toStation.value = fromValue;
            
            // Add animation
            this.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                this.style.transform = 'rotate(0deg)';
            }, 300);
        });
    }
    
    // Prevent selecting same station
    if (fromStation && toStation) {
        fromStation.addEventListener('change', function() {
            if (this.value === toStation.value && this.value !== '') {
                showNotification('Please select different stations for departure and arrival', 'error');
                this.value = '';
            }
        });
        
        toStation.addEventListener('change', function() {
            if (this.value === fromStation.value && this.value !== '') {
                showNotification('Please select different stations for departure and arrival', 'error');
                this.value = '';
            }
        });
    }
    
    // Set minimum date to today
    if (journeyDate) {
        const today = new Date().toISOString().split('T')[0];
        journeyDate.min = today;
        journeyDate.value = today;
    }
}

function initializeSeatSelection() {
    // Seat class selection
    const seatClassCards = document.querySelectorAll('.seat-class-card');
    if (seatClassCards.length > 0) {
        seatClassCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                seatClassCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked card
                this.classList.add('selected');
                
                // Store selection
                const trainNumber = this.dataset.train;
                const classCode = this.dataset.class;
                const fare = this.dataset.fare;
                
                if (trainNumber && classCode && fare) {
                    sessionStorage.setItem('selectedSeatClass', JSON.stringify({
                        train_number: trainNumber,
                        class_code: classCode,
                        fare: fare
                    }));
                }
            });
        });
    }
}

function initializeNotifications() {
    // Auto-hide notifications after 5 seconds
    const notifications = document.querySelectorAll('.notification-success, .notification-error, .notification-info');
    if (notifications.length > 0) {
        notifications.forEach(notification => {
            setTimeout(() => {
                hideNotification(notification);
            }, 5000);
            
            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '×';
            closeBtn.className = 'float-right text-xl font-bold opacity-70 hover:opacity-100';
            closeBtn.addEventListener('click', () => hideNotification(notification));
            notification.appendChild(closeBtn);
        });
    }
}

function initializeLoadingStates() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn-railway, .btn-railway-outline');
    if (buttons.length > 0) {
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.type === 'submit' || this.dataset.loading === 'true') {
                    showLoadingState(this);
                }
            });
        });
    }
}

function initializeAnimations() {
    // Intersection Observer for fade-in animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, {
        threshold: 0.1
    });
    
    // Observe elements with animation classes
    const animatedElements = document.querySelectorAll('.card-railway, .train-card, .form-railway');
    if (animatedElements.length > 0) {
        animatedElements.forEach(el => observer.observe(el));
    }
}

// Utility Functions
function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    let isValid = true;
    let message = '';
    
    // Remove existing error classes
    field.classList.remove('error');
    
    // Basic validation
    if (field.required && !value) {
        isValid = false;
        message = 'This field is required';
    } else if (type === 'email' && value && !isValidEmail(value)) {
        isValid = false;
        message = 'Please enter a valid email address';
    } else if (type === 'tel' && value && !isValidPhone(value)) {
        isValid = false;
        message = 'Please enter a valid phone number';
    }
    
    // Show/hide error
    if (!isValid) {
        field.classList.add('error');
        showFieldError(field, message);
    } else {
        hideFieldError(field);
    }
    
    return isValid;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^(\+88)?01[3-9]\d{8}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

function showFieldError(field, message) {
    let errorElement = field.parentElement.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error text-red-500 text-sm mt-1';
        field.parentElement.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

function hideFieldError(field) {
    const errorElement = field.parentElement.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

function showLoadingState(button) {
    const originalText = button.innerHTML;
    button.dataset.originalText = originalText;
    button.innerHTML = '<span class="loading-railway"></span> Loading...';
    button.disabled = true;
    
    // Reset after 10 seconds (fallback)
    setTimeout(() => {
        hideLoadingState(button);
    }, 10000);
}

function hideLoadingState(button) {
    if (button.dataset.originalText) {
        button.innerHTML = button.dataset.originalText;
        button.disabled = false;
        delete button.dataset.originalText;
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification-${type} fixed top-4 right-4 z-50 max-w-sm fade-in`;
    notification.innerHTML = `
        <div class="flex items-start">
            <div class="flex-1">${message}</div>
            <button class="ml-4 text-xl font-bold opacity-70 hover:opacity-100" onclick="hideNotification(this.parentElement.parentElement)">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideNotification(notification);
    }, 5000);
}

function hideNotification(notification) {
    notification.style.opacity = '0';
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
        if (notification.parentElement) {
            notification.parentElement.removeChild(notification);
        }
    }, 300);
}

// Train Search Functions
function selectTrain(trainNumber, classCode, fare) {
    // Store selection in session storage
    const selection = {
        train_number: trainNumber,
        class_code: classCode,
        fare: fare,
        from_station: getUrlParameter('from_station'),
        to_station: getUrlParameter('to_station'),
        journey_date: getUrlParameter('journey_date'),
        selected_at: new Date().toISOString()
    };
    
    sessionStorage.setItem('selectedTrain', JSON.stringify(selection));
    
    // Show success message
    showNotification('Train selected! Redirecting to seat selection...', 'success');
    
    // Redirect after short delay
    setTimeout(() => {
        window.location.href = '/booking/seat-selection';
    }, 1500);
}

function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Live Tracking Functions
function initializeLiveTracking() {
    // Mock live tracking updates
    setInterval(() => {
        updateTrainStatus();
    }, 30000); // Update every 30 seconds
}

function updateTrainStatus() {
    const statusElements = document.querySelectorAll('.train-status');
    if (statusElements.length > 0) {
        statusElements.forEach(element => {
            // Add pulse animation to indicate live updates
            element.classList.add('pulse-railway');
            setTimeout(() => {
                element.classList.remove('pulse-railway');
            }, 1000);
        });
    }
}

// Booking Functions
function cancelBooking(bookingId) {
    if (confirm('Are you sure you want to cancel this booking?')) {
        showNotification('Cancellation request submitted. You will receive a confirmation email shortly.', 'info');
        
        // Here you would make an API call to cancel the booking
        // For now, just show a success message
        setTimeout(() => {
            showNotification('Booking cancelled successfully. Refund will be processed within 7-10 working days.', 'success');
        }, 2000);
    }
}

function downloadTicket(bookingId) {
    showNotification('Downloading your e-ticket...', 'info');
    
    // Here you would generate and download the PDF ticket
    // For now, just show a success message
    setTimeout(() => {
        showNotification('E-ticket downloaded successfully!', 'success');
    }, 1500);
}

// Export functions for global access
window.selectTrain = selectTrain;
window.cancelBooking = cancelBooking;
window.downloadTicket = downloadTicket;
window.showNotification = showNotification;
window.hideNotification = hideNotification;