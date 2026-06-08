<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support | Sirohi App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <div class="max-w-3xl mx-auto my-12 bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="bg-indigo-900 px-8 py-10 text-white">
            <h1 class="text-4xl font-extrabold tracking-tight">Support Center</h1>
            <p class="mt-2 text-indigo-200 uppercase tracking-widest text-sm font-semibold">Sirohi App Association Helpdesk</p>
        </div>

        <div class="px-8 py-10">
            
            <div class="bg-orange-50 border border-orange-100 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900">Technical Support</h2>
                    <p class="text-lg text-gray-600 mt-1">Lasirene Exim Pvt Ltd (Admin Desk)</p>
                    
                    <a href="mailto:support@lasirene.com" class="mt-4 inline-block text-2xl font-bold text-orange-600 hover:text-orange-700 transition-colors">
                        support@lasirene.com
                    </a>
                </div>
                
                <div class="mt-6 md:mt-0">
                    <div class="bg-white p-4 rounded-full shadow-sm border border-orange-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="Drawing M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mt-10">
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <h3 class="font-bold text-indigo-900 text-lg">Account Access</h3>
                    <p class="text-sm text-gray-500 mt-2">Having trouble with your OTP or forgotten your password? Contact the admin desk for a reset.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <h3 class="font-bold text-indigo-900 text-lg">Event RSVP</h3>
                    <p class="text-sm text-gray-500 mt-2">Need to change your "Accept" or "Reject" status for an association event? We can help update your response.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <h3 class="font-bold text-indigo-900 text-lg">Profile Updates</h3>
                    <p class="text-sm text-gray-500 mt-2">Difficulty adding family members or updating your phone number? Reach out for manual verification.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <h3 class="font-bold text-indigo-900 text-lg">Bug Reporting</h3>
                    <p class="text-sm text-gray-500 mt-2">Found an issue with the Gallery or News feed? Let our technical team know immediately.</p>
                </div>
            </div>

            <div class="pt-12 mt-10 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">Response Time: Typically within 24-48 Business Hours</p>
                <p class="text-xs text-gray-400 mt-2 italic">&copy; {{ date('Y') }} Sirohi App Development Team.</p>
            </div>
        </div>
    </div>

</body>
</html>