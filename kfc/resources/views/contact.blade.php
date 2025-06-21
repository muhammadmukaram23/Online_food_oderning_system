@extends('layouts.app')

@section('title', 'Contact Us - KFC')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    <i class="fas fa-envelope text-danger me-3"></i>
                    Contact Us
                </h1>
                <p class="lead text-muted">
                    We'd love to hear from you! Get in touch with any questions, feedback, or suggestions.
                </p>
            </div>

            <!-- Contact Form -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="firstName" 
                                           name="firstName" 
                                           required
                                           placeholder="Your first name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="lastName" 
                                           name="lastName" 
                                           required
                                           placeholder="Your last name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           required
                                           placeholder="your@email.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="(555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="feedback">Feedback</option>
                                <option value="complaint">Complaint</option>
                                <option value="catering">Catering Services</option>
                                <option value="franchise">Franchise Opportunities</option>
                                <option value="careers">Careers</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Related Location (Optional)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="location" 
                                   name="location" 
                                   placeholder="Which KFC location is this about?">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" 
                                      id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      placeholder="Please share your message, feedback, or inquiry here..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-kfc btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="row mt-5">
        <div class="col-md-4 text-center mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <i class="fas fa-phone fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Call Us</h5>
                    <p class="text-muted">
                        Customer Service<br>
                        <strong>1-800-CALL-KFC</strong><br>
                        <small>Mon-Fri: 8AM-8PM EST</small>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-center mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <i class="fas fa-envelope fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Email Us</h5>
                    <p class="text-muted">
                        Customer Support<br>
                        <strong>support@kfc.com</strong><br>
                        <small>We'll respond within 24 hours</small>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-center mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <i class="fas fa-map-marker-alt fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Visit Us</h5>
                    <p class="text-muted">
                        Find a Location<br>
                        <a href="{{ route('locations') }}" class="text-decoration-none fw-bold" style="color: var(--kfc-red);">
                            Store Locator
                        </a><br>
                        <small>Over 100 locations nationwide</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Frequently Asked Questions</h3>
                <p class="text-muted">Quick answers to common questions</p>
            </div>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                            What are your operating hours?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Most of our locations are open from 6:00 AM to 11:00 PM, but hours may vary by location. 
                            Please check our <a href="{{ route('locations') }}">store locator</a> for specific hours.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                            Do you offer delivery?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes! We offer delivery through our website and mobile app, as well as third-party delivery services. 
                            Delivery availability and fees may vary by location.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                            Do you have vegetarian options?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we offer several vegetarian options including our famous sides like coleslaw, mashed potatoes, 
                            biscuits, and more. Check our <a href="{{ route('menu') }}">menu</a> for full details.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                            How can I provide feedback about my experience?
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We value your feedback! You can contact us through this form, call our customer service line, 
                            or speak with a manager at your local KFC. Your input helps us improve our service.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple form validation and submission simulation
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Basic validation
        if (!data.firstName || !data.lastName || !data.email || !data.subject || !data.message) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Simulate form submission
        alert('Thank you for your message! We will get back to you within 24 hours.');
        form.reset();
    });
});
</script>
@endsection 