// Interactive functionality for Letcon website

document.addEventListener('DOMContentLoaded', function() {
  // Smooth scrolling for navigation links
  const links = document.querySelectorAll('a[href^="#"]');
  
  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      const targetSection = document.querySelector(targetId);
      
      if (targetSection) {
        const headerHeight = document.querySelector('header').offsetHeight;
        const targetPosition = targetSection.offsetTop - headerHeight - 20;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // Header background change on scroll
  const header = document.querySelector('header');
  
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      header.classList.add('backdrop-blur-md');
      header.classList.remove('backdrop-blur-sm');
    } else {
      header.classList.remove('backdrop-blur-md');
      header.classList.add('backdrop-blur-sm');
    }
  });

  // Newsletter subscription
  const newsletterForm = document.querySelector('footer input[type="email"] + button');
  const newsletterInput = document.querySelector('footer input[type="email"]');

  if (newsletterForm && newsletterInput) {
    newsletterForm.addEventListener('click', function(e) {
      e.preventDefault();
      
      const email = newsletterInput.value;
      
      if (email && isValidEmail(email)) {
        // Simulate subscription (in real app, this would call an API)
        newsletterInput.value = '';
        showNotification('Thank you for subscribing!', 'success');
      } else {
        showNotification('Please enter a valid email address.', 'error');
      }
    });

    newsletterInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        newsletterForm.click();
      }
    });
  }

  // CTA buttons functionality
  const ctaButtons = document.querySelectorAll('.btn-hero');
  
  ctaButtons.forEach(button => {
    if (button.textContent.includes('Join') || button.textContent.includes('Get Started')) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        showNotification('Redirecting to registration...', 'info');
        // In real app: window.location.href = '/register';
      });
    }
    
    if (button.textContent.includes('Schedule')) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        showNotification('Opening calendar booking...', 'info');
        // In real app: open calendar booking widget
      });
    }
  });

  // Mobile menu toggle (if needed in future)
  const mobileMenuButton = document.querySelector('[data-mobile-menu]');
  const mobileMenu = document.querySelector('[data-mobile-menu-content]');
  
  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
    });
  }

  // Intersection Observer for animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in');
      }
    });
  }, observerOptions);

  // Observe cards and sections for animations
  const animateElements = document.querySelectorAll('.card, section > div > div');
  animateElements.forEach(el => observer.observe(el));
});

// Utility functions
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function showNotification(message, type = 'info') {
  // Create notification element
  const notification = document.createElement('div');
  notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full opacity-0 transition-all duration-300`;
  
  // Set background color based on type
  switch(type) {
    case 'success':
      notification.classList.add('bg-letcon-primary');
      break;
    case 'error':
      notification.classList.add('bg-red-500');
      break;
    case 'info':
    default:
      notification.classList.add('bg-letcon-gold', 'text-letcon-neutral-900');
      break;
  }
  
  notification.textContent = message;
  document.body.appendChild(notification);
  
  // Animate in
  setTimeout(() => {
    notification.classList.remove('translate-x-full', 'opacity-0');
  }, 100);
  
  // Animate out and remove
  setTimeout(() => {
    notification.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

// Add fade-in animation class
const style = document.createElement('style');
style.textContent = `
  .animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
`;
document.head.appendChild(style);