<style>
    body {
        font-family: 'Raleway', sans-serif;
    }

    .section-icon {
        background-color: #F59E0B;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .hover-effect:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
</style>
<x-frontend-layout />
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">

<body class="bg-lightBg text-gray-800 font-raleway">
    <!-- Header -->


    <!-- Page Title -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4 mt-5">
            <div class="flex items-center">
                <i class="fas fa-shield-alt text-4xl text-primary mr-4"></i>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-primary">Privacy Policy</h1>
                    <p class="text-gray-600 mt-2">Last updated: August 30, 2023</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Introduction -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-info"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Introduction / Overview</h2>
            </div>
            <p class="text-gray-700 mb-4 leading-relaxed">
                Welcome to TechLearn's Privacy Policy. This policy describes how we collect, use, and share your
                personal information when you use our IT course platform.
                We are committed to protecting your privacy and ensuring transparency about our data practices.
            </p>
            <p class="text-gray-700 leading-relaxed">
                By accessing or using our services, you agree to the terms of this Privacy Policy. If you do not agree
                with our policies and practices,
                please do not use our platform.
            </p>
        </section>

        <!-- Information We Collect -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Information We Collect</h2>
            </div>
            <div class="ml-4 md:ml-16">
                <h3 class="text-xl font-semibold text-secondary mb-3">Personal Information</h3>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li>Name, email address, and contact details</li>
                    <li>Payment information for course purchases</li>
                    <li>Educational background and professional interests</li>
                    <li>Course progress and completion certificates</li>
                </ul>

                <h3 class="text-xl font-semibold text-secondary mb-3">Non-Personal Information</h3>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li>Browser type and version</li>
                    <li>Device information and operating system</li>
                    <li>Pages visited and time spent on platform</li>
                    <li>Course preferences and search queries</li>
                </ul>

                <h3 class="text-xl font-semibold text-secondary mb-3">Cookies and Tracking Technologies</h3>
                <p class="text-gray-700 mb-4">
                    We use cookies and similar technologies to enhance your experience, analyze platform usage, and
                    deliver personalized content.
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-2">
                    <li>Session cookies for platform functionality</li>
                    <li>Analytics cookies to understand user behavior</li>
                    <li>Advertising cookies to deliver relevant course recommendations</li>
                </ul>
            </div>
        </section>

        <!-- How We Use Your Information -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">How We Use Your Information</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-user-check text-secondary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Account Management</h3>
                    <p class="text-gray-700 text-sm">Create and manage your user account, process payments, and provide
                        customer support.</p>
                </div>
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-graduation-cap text-secondary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Personalized Learning</h3>
                    <p class="text-gray-700 text-sm">Recommend courses based on your interests and track your learning
                        progress.</p>
                </div>
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-chart-line text-secondary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Platform Improvement</h3>
                    <p class="text-gray-700 text-sm">Analyze usage patterns to enhance our platform and develop new
                        features.</p>
                </div>
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-envelope text-secondary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Communication</h3>
                    <p class="text-gray-700 text-sm">Send important updates, course notifications, and promotional
                        offers (with your consent).</p>
                </div>
            </div>
        </section>

        <!-- Sharing and Disclosure -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-share-alt"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Sharing and Disclosure of Information</h2>
            </div>
            <p class="text-gray-700 mb-4">
                We value your privacy and do not sell your personal information to third parties. We may share your
                information in the following circumstances:
            </p>
            <ul class="list-disc pl-5 text-gray-700 space-y-2">
                <li><span class="font-semibold">Instructors:</span> Share progress information with course instructors
                    to facilitate learning</li>
                <li><span class="font-semibold">Service Providers:</span> With trusted partners who assist in platform
                    operations</li>
                <li><span class="font-semibold">Legal Requirements:</span> When required by law or to protect our rights
                    and safety</li>
                <li><span class="font-semibold">Business Transfers:</span> In connection with a merger, acquisition, or
                    sale of assets</li>
            </ul>
        </section>

        <!-- Data Security -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Data Security Measures</h2>
            </div>
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="md:w-1/2 mb-6 md:mb-0 md:pr-4">
                    <p class="text-gray-700 mb-4">
                        We implement industry-standard security measures to protect your personal information from
                        unauthorized access, alteration, or destruction.
                    </p>
                    <ul class="list-disc pl-5 text-gray-700 space-y-2">
                        <li>SSL encryption for all data transmissions</li>
                        <li>Regular security audits and vulnerability assessments</li>
                        <li>Secure storage systems with restricted access</li>
                        <li>Employee training on data protection protocols</li>
                    </ul>
                </div>
                <div class="md:w-1/2 bg-primary text-white p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-3">Our Security Commitment</h3>
                    <p class="mb-4">We continuously monitor and update our security practices to address emerging
                        threats and vulnerabilities.</p>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-secondary text-2xl mr-3"></i>
                        <p>All payment information is processed through PCI DSS compliant payment processors</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- User Rights -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">User Rights</h2>
            </div>
            <p class="text-gray-700 mb-6">
                You have certain rights regarding your personal information. To exercise any of these rights, please
                contact us using the information provided below.
            </p>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="border-l-4 border-secondary pl-4 py-2">
                    <h3 class="font-semibold text-primary">Access</h3>
                    <p class="text-gray-700 text-sm">Request a copy of the personal information we hold about you.</p>
                </div>
                <div class="border-l-4 border-secondary pl-4 py-2">
                    <h3 class="font-semibold text-primary">Correction</h3>
                    <p class="text-gray-700 text-sm">Update or correct inaccurate information in your account.</p>
                </div>
                <div class="border-l-4 border-secondary pl-4 py-2">
                    <h3 class="font-semibold text-primary">Deletion</h3>
                    <p class="text-gray-700 text-sm">Request deletion of your personal information, subject to certain
                        exceptions.</p>
                </div>
                <div class="border-l-4 border-secondary pl-4 py-2">
                    <h3 class="font-semibold text-primary">Opt-Out</h3>
                    <p class="text-gray-700 text-sm">Opt-out of marketing communications and certain data processing
                        activities.</p>
                </div>
            </div>
        </section>

        <!-- Third-Party Services -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-external-link-alt"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Third-Party Services and Links</h2>
            </div>
            <p class="text-gray-700 mb-4">
                Our platform may integrate with or link to third-party services, such as payment processors, video
                hosting services, and social media platforms.
            </p>
            <div class="bg-lightBg p-4 rounded-lg mt-4">
                <h3 class="font-semibold text-primary mb-2">Important Notice</h3>
                <p class="text-gray-700 text-sm">
                    These third-party services have their own privacy policies, and we are not responsible for their
                    practices.
                    We encourage you to review the privacy policies of any third-party services you access through our
                    platform.
                </p>
            </div>
        </section>

        <!-- Policy Changes -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Changes to the Privacy Policy</h2>
            </div>
            <p class="text-gray-700 mb-4">
                We may update this Privacy Policy from time to time to reflect changes in our practices or legal
                requirements.
                We will notify you of any material changes by posting the updated policy on our platform and updating
                the "Last updated" date.
            </p>
            <div class="bg-yellow-50 border-l-4 border-secondary p-4 mt-4">
                <p class="text-gray-700">
                    <i class="fas fa-exclamation-circle text-secondary mr-2"></i>
                    We encourage you to review this policy periodically to stay informed about our information
                    practices.
                </p>
            </div>
        </section>

        <!-- Contact Information -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-10 hover-effect transition duration-300">
            <div class="flex items-center mb-6">
                <div class="section-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h2 class="text-2xl font-bold text-primary">Contact Information</h2>
            </div>
            <p class="text-gray-700 mb-6">
                If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices,
                please contact us:
            </p>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-envelope text-primary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Email</h3>
                    <p class="text-gray-700">privacy@techlearn.com</p>
                </div>
                <div class="bg-lightBg p-4 rounded-lg">
                    <i class="fas fa-map-marker-alt text-primary text-xl mb-2"></i>
                    <h3 class="font-semibold text-primary mb-2">Address</h3>
                    <p class="text-gray-700">123 Tech Avenue, Silicon Valley, CA 94043</p>
                </div>
            </div>
            <p class="text-gray-700 mt-6">
                We typically respond to privacy-related inquiries within 3-5 business days.
            </p>
        </section>
    </main>

    <!-- Footer -->
    <x-frontend-footer />
</body>

</html>
