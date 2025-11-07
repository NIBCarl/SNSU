<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- Top Navigation -->
        <nav class="w-full px-6 py-3 bg-white shadow-md sticky top-0 z-50">
            <div class="flex justify-end">
                <inertia-link href="/login" class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Login
                </inertia-link>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl w-full space-y-8 p-6 sm:p-10 bg-white shadow-xl rounded-lg">
                <!-- University Logo - MOVED TO TOP -->
                <div class="logo-container flex justify-center items-center mb-6 sm:mb-8">
                    <img class="h-40 w-40 sm:h-48 sm:w-48 object-contain" src="/assets/logo2.png" alt="University Logo" />
                </div>

                <!-- Student Information Form -->
                <div class="form-container">
                    <h2 class="text-center text-2xl sm:text-3xl font-extrabold text-gray-900">
                        Student Information Form
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please fill out your details below.
                    </p>
                    <form @submit.prevent="submitStudentForm" class="mt-8 space-y-6">
                        <!-- Personal Information Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" v-model="form.first_name" class="input-field" required />
                            </div>
                            <div>
                                <label for="middle_name">Middle Name</label>
                                <input type="text" id="middle_name" v-model="form.middle_name" class="input-field" />
                            </div>
                            <div>
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" v-model="form.last_name" class="input-field" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="student_id">Student ID</label>
                                <input type="text" id="student_id" v-model="form.student_id" class="input-field" required />
                            </div>
                            <div>
                                <label for="birth_date">Birth Date</label>
                                <input type="date" id="birth_date" v-model="form.birth_date" class="input-field" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="gender">Gender</label>
                                <select id="gender" v-model="form.gender" class="input-field" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="marital_status">Marital Status</label>
                                <select id="marital_status" v-model="form.marital_status" class="input-field" required>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="religion">Religion</label>
                                <input type="text" id="religion" v-model="form.religion" class="input-field" required />
                            </div>
                            <div>
                                <label for="cellphone_number">Cellphone Number</label>
                                <input type="tel" id="cellphone_number" v-model="form.cellphone_number" class="input-field" />
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                         <div>
                            <label for="course">Course</label>
                            <input type="text" id="course" v-model="form.course" class="input-field" required />
                        </div>
                        <div>
                            <label for="year_level">Year Level</label>
                            <select id="year_level" v-model="form.year_level" class="input-field" required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>


                        <!-- Address Section -->
                        <div>
                            <label for="address">Address (House No./Street)</label>
                            <input type="text" id="address" v-model="form.address" class="input-field" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="barangay">Barangay</label>
                                <input type="text" id="barangay" v-model="form.barangay" class="input-field" required />
                            </div>
                            <div>
                                <label for="city">City/Municipality</label>
                                <input type="text" id="city" v-model="form.city" class="input-field" required />
                            </div>
                            <div>
                                <label for="province">Province</label>
                                <input type="text" id="province" v-model="form.province" class="input-field" required />
                            </div>
                        </div>
                        <div>
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" v-model="form.postal_code" class="input-field" required />
                        </div>

                        <!-- Parent Information Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="father_name">Father's Name</label>
                                <input type="text" id="father_name" v-model="form.father_name" class="input-field" placeholder="e.g., Juan Dela Cruz" required />
                            </div>
                            <div>
                                <label for="mother_name">Mother's Name</label>
                                <input type="text" id="mother_name" v-model="form.mother_name" class="input-field" placeholder="e.g., Maria Dela Cruz" required />
                            </div>
                            <div>
                                <label for="family_income">Family Income (Monthly Gross)</label>
                                <select id="family_income" v-model="form.family_income" class="input-field" required>
                                    <option value="">Select Family Income</option>
                                    <option value="Php 62,000 & Below">Php 62,000 & Below</option>
                                    <option value="Php 62,100 - Php 101,000">Php 62,100 - Php 101,000</option>
                                    <option value="Php 101,100 - Php 151,000">Php 101,100 - Php 151,000</option>
                                    <option value="Php 191,100 - Php 231,000">Php 191,100 - Php 231,000</option>
                                    <option value="Php 231,100 - Php 271,000">Php 231,100 - Php 271,000</option>
                                    <option value="Php 271,100 - Php 301,000">Php 271,100 - Php 301,000</option>
                                    <option value="Php 301,100 - Php 351,000">Php 301,100 - Php 351,000</option>
                                    <option value="Php 351,100 - Php 391,000">Php 351,100 - Php 391,000</option>
                                    <option value="Php 391,100 - Php 431,000">Php 391,100 - Php 431,000</option>
                                    <option value="Php 431,100 - Php 741,000">Php 431,100 - Php 741,000</option>
                                    <option value="Php 471,100 - Php 501,000">Php 471,100 - Php 501,000</option>
                                    <option value="Php 501,100 - Php 551,000">Php 501,100 - Php 551,000</option>
                                    <option value="Php 551,100 - Php 591,000">Php 551,100 - Php 591,000</option>
                                    <option value="Php 591,100 - Php 603,000">Php 591,100 - Php 603,000</option>
                                    <option value="Php 603,000 and above">Php 603,000 and above</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>

                        <!-- Socio-Economic Information Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="study_device">Primary Study Device</label>
                                <select id="study_device" v-model="form.study_device" class="input-field">
                                    <option value="">Select Study Device</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Mobile Phone">Mobile Phone</option>
                                </select>
                            </div>
                            <div>
                                <label for="household_size">Household Size</label>
                                <input type="number" id="household_size" v-model.number="form.household_size" class="input-field" placeholder="e.g., 5" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="housing_status">Housing Status</label>
                                <select id="housing_status" v-model="form.housing_status" class="input-field" required>
                                    <option value="">Select Housing Status</option>
                                    <option value="Owned">Owned</option>
                                    <option value="Renting">Renting</option>
                                    <option value="Living with Relatives">Living with Relatives</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="checkbox-label">
                                <input type="checkbox" id="is_solo_parent" v-model="form.is_solo_parent" class="checkbox-input" />
                                <label for="is_solo_parent" class="ml-2">Are you a solo parent?</label>
                            </div>
                            <div v-if="form.is_solo_parent">
                                <label for="solo_parent_id">Solo Parent ID No.</label>
                                <input type="text" id="solo_parent_id" v-model="form.solo_parent_id" class="input-field" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="checkbox-label">
                                <input type="checkbox" id="has_part_time_job" v-model="form.has_part_time_job" class="checkbox-input" />
                                <label for="has_part_time_job" class="ml-2">Do you have a part-time job?</label>
                            </div>
                            <div class="checkbox-label">
                                <input type="checkbox" id="pwd" v-model="form.pwd" class="checkbox-input" />
                                <label for="pwd" class="ml-2">Are you a Person with Disability (PWD)?</label>
                            </div>
                            <div v-if="form.pwd">
                                <label for="pwd_id">PWD ID Number</label>
                                <input type="text" id="pwd_id" v-model="form.pwd_id" class="input-field" placeholder="PWD ID No." />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="daily_fare">Daily Fare (PHP)</label>
                                <select id="daily_fare" v-model="form.daily_fare" class="input-field">
                                    <option value="">Select Daily Fare</option>
                                    <option value="Php 20.00 - Php 50.00">Php 20.00 - Php 50.00</option>
                                    <option value="Php. 51.00 - Php 100.00">Php. 51.00 - Php 100.00</option>
                                    <option value="Php 101.00 - Php 200.00">Php 101.00 - Php 200.00</option>
                                    <option value="Php 201.00 - Php 300.00">Php 201.00 - Php 300.00</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                            <div>
                                <label for="monthly_rental">Monthly Boarding/Rental (PHP, if applicable)</label>
                                <input type="number" id="monthly_rental" v-model.number="form.monthly_rental" class="input-field" placeholder="e.g., 2500" />
                            </div>
                        </div>

                        <!-- Transportation & Ethnicity Section -->
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="transportation_mode">Mode of Transportation to School</label>
                                <select id="transportation_mode" v-model="form.transportation_mode" class="input-field" required>
                                    <option value="">Select Transportation</option>
                                    <option value="Car">Car</option>
                                    <option value="Jeep/Multicab">Jeep/Multicab</option>
                                    <option value="Motorcycle">Motorcycle</option>
                                    <option value="Tricycle">Tricycle</option>
                                    <option value="None">None</option>
                                </select>
                            </div>
                            <div>
                                <label for="travel_time_minutes">Travel Time to School (minutes)</label>
                                <input type="number" id="travel_time_minutes" v-model.number="form.travel_time_minutes" class="input-field" placeholder="e.g., 30" required />
                            </div>
                             <div>
                                <label for="ethnicity">Ethnicity</label>
                                <select id="ethnicity" v-model="form.ethnicity" class="input-field" required>
                                    <option value="">Select Ethnicity</option>
                                    <option value="Indigenous">Indigenous</option>
                                    <option value="Non-Indigenous">Non-Indigenous</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-red-500 text-sm mt-2" v-if="form.hasErrors">
                            <p v-for="error in form.errors" :key="error">{{ error }}</p>
                        </div>

                        <div>
                            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" :disabled="form.processing">
                                Submit Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link as InertiaLink, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Define form structure based on StudentController@store validation
const form = useForm({
    first_name: '',
    middle_name: '',
    last_name: '',
    student_id: '',
    course: '',
    year_level: '',
    gender: '', // Set to '' or a default like 'Male' if appropriate
    birth_date: '',
    marital_status: 'Single', // Default value
    religion: '',
    cellphone_number: '',
    address: '',
    barangay: '',
    city: '',
    province: '',
    postal_code: '',
    study_device: '',
    is_solo_parent: false,
    solo_parent_id: '',
    has_part_time_job: false,
    daily_fare: '',
    monthly_rental: null,
    father_name: '',
    mother_name: '',
    household_size: null,
    transportation_mode: '',
    travel_time_minutes: null,
    ethnicity: '',
    pwd: false,
    pwd_id: '',
    housing_status: '',
    family_income: '',
    processing: false,
});

const submitStudentForm = () => {
    form.post('/student', {
        onSuccess: () => {
            // Redirect handled by controller
        },
        onError: (errors) => {
            console.error('Form submission error:', errors);
            // Optionally, display errors more visibly to the user
        }
    });
};

</script>

<style scoped>
/* Remove responsive order styles as they are no longer needed */
/* .form-container { order: ... } */
/* .logo-container { order: ... } */
/* @media (min-width: 768px) { ... order styles ... } */

/* Basic responsive adjustments and centering */
/* Styles for .form-container and .logo-container are now simpler as they stack */

.input-field {
    @apply block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm;
    /* Ensure width and box-sizing for robustness */
    width: 100% !important; /* Tailwind's w-full is usually enough, but !important can override conflicts */
    box-sizing: border-box !important;
}

label {
    @apply block text-sm font-medium text-gray-700 mb-1;
}

/* Styling for select dropdowns */
select.input-field {
    appearance: none; /* Remove default arrow in some browsers */
    background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 h-5 w-5"%3e%3cpath d="M7 7l3-3 3 3m0 6l-3 3-3-3"/%3e%3c/svg%3e');
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25em 1.25em;
    padding-right: 2.5rem; /* Make space for arrow */
}

/* Styling for checkboxes */
.checkbox-label {
    @apply flex items-center;
}
.checkbox-input {
    @apply h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500;
}
.checkbox-input:checked {
    background-color: #4F46E5;
    border-color: #4F46E5;
}

/* Ensure logo is not overly large on smaller screens but can grow */
.logo-container img {
    /* max-height: 240px; */ /* Control size with h-X w-X classes directly in template */
    display: block; 
    margin-left: auto;
    margin-right: auto;
}

/* @media (min-width: 768px) { ... .logo-container img { max-height: none; } ... } */ /* Remove as size is controlled by template classes */

/* Additional styling for the logo container if needed */
.logo-container {
    /* Example: Add a background or border if desired */
}

</style> 