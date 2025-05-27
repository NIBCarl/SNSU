<template>
  <Head title="Submission Successful" />
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">
    <div class="bg-white p-8 sm:p-10 rounded-lg shadow-xl text-center max-w-md w-full">
      <div class="mb-6">
        <!-- You can use an SVG icon or an <img> tag for a checkmark -->
        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      </div>
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">Thank You!</h1>
      <p class="text-gray-600 mb-8 sm:text-lg">
        Your information has been submitted successfully.
      </p>
      
      <div class="space-y-4">
        <inertia-link 
          :href="route('welcome')" 
          class="block w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
          Fill Up Again
        </inertia-link>
        
        <inertia-link 
          :href="route('login')" 
          class="block w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
          Proceed to Login
        </inertia-link>

        <!-- Optional: A more subdued link to go back to the absolute home page if it differs from fill up again -->
        <!-- 
        <inertia-link 
          :href="route('welcome')"
          class="inline-block text-sm text-gray-500 hover:text-gray-700 mt-4"
        >
          Back to site home
        </inertia-link>
        -->
      </div>
    </div>
    <footer class="mt-8 text-center">
        <p class="text-sm text-gray-500">&copy; {{ new Date().getFullYear() }} SNSU. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { Head, Link as InertiaLink } from '@inertiajs/vue3';

// If you flashed a specific message from the controller, you could access it via $page.props.flash.message
// import { usePage } from '@inertiajs/vue3';
// const page = usePage();
// const successMessage = page.props.flash?.message || 'Your information has been submitted successfully.';

</script>

<style scoped>
/* Add any specific styles if needed, e.g., for background patterns or custom fonts */
</style> 