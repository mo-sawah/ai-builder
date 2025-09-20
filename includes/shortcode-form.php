<?php
// This just prevents direct access to the file
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="ai-builder-container" class="gradient-bg text-white min-h-screen -m-4 sm:-m-8">
    <div class="container mx-auto px-6 py-8">
        <div class="text-center mb-12 fade-in">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <h1 class="text-4xl font-bold text-white">AI Website Builder</h1>
            </div>
            <p class="text-xl text-gray-300 max-w-4xl mx-auto mb-6">
                Describe your business and watch AI create a complete website concept with wireframes, 
                color schemes, cost estimates, and a full strategic plan.
            </p>
        </div>

        <!-- FORM SECTION -->
        <div class="max-w-6xl mx-auto space-y-8" id="form-section">
            
            <!-- Business Information -->
            <div class="glass rounded-2xl p-8 fade-in">
                <h3 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    Business Information
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="businessType" class="block text-gray-300 mb-2 font-medium">Business Name/Type</label>
                        <input type="text" id="businessType" placeholder="e.g., TechFlow Solutions, Local Restaurant" class="w-full" />
                    </div>
                     <div>
                        <label for="industry" class="block text-gray-300 mb-2 font-medium">Industry</label>
                        <div class="relative">
                            <select id="industry" class="w-full">
                                <option value="">Select Industry</option>
                                <option value="Technology & Software">Technology & Software</option>
                                <option value="Healthcare & Medical">Healthcare & Medical</option>
                                <option value="E-commerce & Retail">E-commerce & Retail</option>
                                <option value="Education & Training">Education & Training</option>
                                <option value="Finance & Banking">Finance & Banking</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Restaurant & Food">Restaurant & Food</option>
                                <option value="Legal Services">Legal Services</option>
                                <option value="Creative Agency">Creative Agency</option>
                                <option value="Non-Profit">Non-Profit</option>
                                <option value="Fitness & Wellness">Fitness & Wellness</option>
                                <option value="Travel & Tourism">Travel & Tourism</option>
                                <option value="Automotive">Automotive</option>
                                <option value="Fashion & Beauty">Fashion & Beauty</option>
                                <option value="Construction">Construction</option>
                                <option value="Consulting">Consulting</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Photography">Photography</option>
                                <option value="Marketing & Advertising">Marketing & Advertising</option>
                                <option value="Professional Services">Professional Services</option>
                                <option value="Architecture & Design">Architecture & Design</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></div>
                        </div>
                    </div>
                    <div>
                        <label for="targetAudience" class="block text-gray-300 mb-2 font-medium">Target Audience</label>
                        <input type="text" id="targetAudience" placeholder="e.g., Small businesses, Young professionals" class="w-full" />
                    </div>
                    <div>
                        <label for="businessGoal" class="block text-gray-300 mb-2 font-medium">Primary Business Goal</label>
                        <div class="relative">
                            <select id="businessGoal" class="w-full">
                                <option value="">Select Primary Goal</option>
                                <option value="Generate Leads">Generate Leads</option>
                                <option value="Sell Products Online">Sell Products Online</option>
                                <option value="Build Brand Awareness">Build Brand Awareness</option>
                                <option value="Provide Information">Provide Information</option>
                                <option value="Showcase Portfolio">Showcase Portfolio</option>
                                <option value="Accept Bookings/Appointments">Accept Bookings/Appointments</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg></div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="businessDescription" class="block text-gray-300 mb-2 font-medium">Brief Description of Your Business</label>
                        <textarea id="businessDescription" placeholder="Tell us about your business, what you do, and what makes you unique..." rows="3" class="w-full resize-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- Website & Design Preferences -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="glass rounded-2xl p-6 fade-in">
                    <h3 class="text-xl font-semibold text-white mb-4 flex items-center"><svg class="w-5 h-5 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>Website Type</h3>
                    <div class="grid grid-cols-2 gap-3" id="websiteTypes">
                        <button class="website-type w-full p-2.5 rounded-xl border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-left" data-value="Business Website"><div class="font-medium text-sm">Business Website</div><div class="text-xs text-gray-400">For companies</div></button>
                        <button class="website-type w-full p-2.5 rounded-xl border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-left" data-value="E-commerce Store"><div class="font-medium text-sm">E-commerce Store</div><div class="text-xs text-gray-400">Sell products online</div></button>
                        <button class="website-type w-full p-2.5 rounded-xl border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-left" data-value="Portfolio Site"><div class="font-medium text-sm">Portfolio Site</div><div class="text-xs text-gray-400">For creatives</div></button>
                        <button class="website-type w-full p-2.5 rounded-xl border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-left" data-value="Blog/Magazine"><div class="font-medium text-sm">Blog/Magazine</div><div class="text-xs text-gray-400">For publishers</div></button>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6 fade-in">
                     <h3 class="text-xl font-semibold text-white mb-4 flex items-center"><svg class="w-5 h-5 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" /></svg>Design Style Preference</h3>
                    <div class="grid grid-cols-2 gap-2 max-h-64 overflow-y-auto pr-2" id="designStyles">
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Modern & Clean">Modern & Clean</button>
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Professional & Corporate">Professional & Corporate</button>
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Creative & Artistic">Creative & Artistic</button>
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Minimalist">Minimalist</button>
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Bold & Vibrant">Bold & Vibrant</button>
                        <button class="design-style p-2 rounded-lg border-2 border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-300 text-sm" data-value="Elegant & Luxury">Elegant & Luxury</button>
                    </div>
                </div>
            </div>
            
            <!-- Features -->
             <div class="glass rounded-2xl p-8 fade-in">
                <h3 class="text-2xl font-semibold text-white mb-6 flex items-center"><svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>Select Desired Features</h3>
                <div class="grid lg:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-lg font-medium text-white mb-4">Essential</h4>
                        <div class="space-y-2" id="essentialFeatures">
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Contact Forms">Contact Forms</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Mobile Responsive">Mobile Responsive</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="SEO Optimization">SEO Optimization</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Testimonials">Testimonials</button>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-white mb-4">Business</h4>
                        <div class="space-y-2" id="businessFeatures">
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Online Booking">Online Booking</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="E-commerce Store">E-commerce Store</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Payment Gateway">Payment Gateway</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="CRM Integration">CRM Integration</button>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-white mb-4">Advanced</h4>
                        <div class="space-y-2" id="advancedFeatures">
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Live Chat">Live Chat</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="AI Chatbot">AI Chatbot</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="Blog System">Blog System</button>
                            <button class="feature w-full p-2 rounded-lg border border-gray-600 bg-gray-700/30 text-gray-300 hover:border-purple-400 transition-all duration-200 text-sm text-left" data-value="User Registration">User Registration</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center fade-in">
                <button id="generateBtn" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-4 px-12 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center mx-auto text-lg">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                    Generate AI Website Concept
                </button>
                <p id="validation-message" class="text-red-400 text-sm mt-4 hidden">
                    Please fill in Business Name and Industry to continue.
                </p>
            </div>
        </div>

        <!-- LOADING SECTION -->
        <div id="loading-section" class="max-w-4xl mx-auto mt-16 hidden">
            <div class="glass rounded-2xl p-8">
                <div class="text-center">
                    <div class="spinner mx-auto mb-8"></div>
                    <h3 class="text-2xl font-semibold text-white mb-6">AI is Crafting Your Strategic Plan...</h3>
                    <div class="space-y-3 max-w-2xl mx-auto text-left" id="progress-steps">
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Analyzing business requirements...</div></div>
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Defining target audience & USP...</div></div>
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Developing brand identity...</div></div>
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Structuring sitemap and user flow...</div></div>
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Building detailed wireframes...</div></div>
                        <div class="progress-step text-sm p-4 rounded-lg bg-gray-700/30 text-gray-400 border border-transparent"><div class="flex items-center"><div></div>Finalizing recommendations...</div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULTS SECTION -->
        <div id="results-section" class="max-w-6xl mx-auto mt-16 space-y-8 hidden">
            <!-- Header -->
            <div class="text-center">
                 <h2 class="text-4xl font-bold text-white mb-4">Your AI-Generated Website Concept is Ready!</h2>
            </div>
            
            <div class="bg-gradient-to-br from-purple-600/20 to-blue-600/20 backdrop-blur-sm rounded-2xl p-8 border border-purple-500/30 report-section">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2" id="conceptBusinessName"></h2>
                        <p class="text-purple-300 text-xl font-medium mb-4" id="conceptTagline"></p>
                    </div>
                    <button id="resetBtn" class="p-3 bg-gray-700/50 rounded-lg text-gray-300 hover:text-white transition-colors" title="Generate New Concept">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </button>
                </div>
                
                <p class="text-gray-300 mb-8 text-lg leading-relaxed" id="conceptDescription"></p>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800/50 rounded-xl p-4 text-center"><div class="text-2xl font-bold text-green-400" id="metric-cost"></div><div class="text-gray-400 text-sm">Estimated Cost</div></div>
                    <div class="bg-gray-800/50 rounded-xl p-4 text-center"><div class="text-2xl font-bold text-blue-400" id="metric-timeline"></div><div class="text-gray-400 text-sm">Timeline</div></div>
                    <div class="bg-gray-800/50 rounded-xl p-4 text-center"><div class="text-2xl font-bold text-purple-400" id="metric-pages"></div><div class="text-gray-400 text-sm">Pages</div></div>
                </div>
            </div>

            <!-- Branding -->
            <div class="glass rounded-2xl p-8 report-section" style="animation-delay: 0.1s;">
                 <h3 class="text-2xl font-semibold text-white mb-6 flex items-center"><svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" /></svg>Branding & Visual Identity</h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-medium text-white mb-4">Color Palette</h4>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="colorPalette"></div>
                    </div>
                     <div>
                        <h4 class="text-lg font-medium text-white mb-4">Typography</h4>
                        <div class="space-y-4" id="typography"></div>
                    </div>
                </div>
            </div>

            <!-- Sitemap -->
             <div class="glass rounded-2xl p-8 report-section" style="animation-delay: 0.2s;">
                 <h3 class="text-2xl font-semibold text-white mb-6 flex items-center"><svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>Sitemap & Page Structure</h3>
                <ul id="sitemap-list" class="space-y-2"></ul>
            </div>

            <!-- Wireframes -->
             <div class="glass rounded-2xl p-8 report-section" style="animation-delay: 0.3s;">
                <h3 class="text-2xl font-semibold text-white mb-6 flex items-center"><svg class="w-6 h-6 text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>Detailed Page Wireframes</h3>
                <div id="wireframes-container"></div>
            </div>

            <!-- Call to Action Buttons -->
            <div class="grid md:grid-cols-3 gap-6 report-section" style="animation-delay: 0.4s;">
                <button onclick="alert('This feature is coming soon!')" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Download PDF
                </button>
                <button onclick="alert('This feature is coming soon!')" class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Build Live Demo
                </button>
                <button onclick="window.open('https://sawahsolutions.com/get-started', '_blank')" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    Request a Quote
                </button>
            </div>

        </div>
    </div>
</div>
