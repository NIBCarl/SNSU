<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- Top Navigation -->
        <nav class="w-full px-6 py-3 bg-white shadow-md sticky top-0 z-50">
            <div class="flex justify-end">
                <inertia-link href="/login" class="login-button">
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
                        <h3 class="section-heading">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="student_id">Student ID</label>
                                <input 
                                    type="text" 
                                    id="student_id" 
                                    v-model="form.student_id" 
                                    class="input-field" 
                                    pattern="\d{4}-\d{5}"
                                    placeholder="2023-01292"
                                    title="Format: YYYY-##### (e.g., 2023-01292)"
                                    required 
                                />
                                <p class="input-helper-text">Format: YYYY-##### (e.g., 2023-01292)</p>
                            </div>
                            <div>
                                <label for="birth_date">Birth Date</label>
                                <input type="date" id="birth_date" v-model="form.birth_date" class="input-field" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gender">Gender</label>
                                <select id="gender" v-model="form.gender" class="input-field" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="marital_status">Marital Status</label>
                                <select id="marital_status" v-model="form.marital_status" class="input-field" required>
                                    <option value="">Select Marital Status</option>
                                    <option value="Single (Never Married)">Single (Never Married)</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        <h3 class="section-heading">Academic Information</h3>
                         <div>
                            <label for="course">Course</label>
                            <select id="course" v-model="form.course" class="input-field" required>
                                <option value="">Select Course</option>
                                <option value="BSCE">BSCE - Bachelor of Science in Civil Engineering</option>
                                <option value="BSECE">BSECE - Bachelor of Science in Electronics and Communications Engineering</option>
                                <option value="BSEE">BSEE - Bachelor of Science in Electrical Engineering</option>
                                <option value="BSCpE">BSCpE - Bachelor of Science in Computer Engineering</option>
                                <option value="BSIS">BSIS - Bachelor of Science in Information Systems</option>
                                <option value="BSInfoTech">BSInfoTech - Bachelor of Science in Information Technology</option>
                                <option value="BSCS">BSCS - Bachelor of Science in Computer Science</option>
                                <option value="BAET">BAET - Bachelor of Automotive Engineering Technology</option>
                                <option value="BEET">BEET - Bachelor of Electronics Engineering Technology</option>
                                <option value="BEXET">BEXET - Bachelor of Electro-Mechanical Engineering Technology</option>
                                <option value="BMET–MT">BMET–MT - Bachelor of Mechanical Engineering Technology - Mechanical Technology</option>
                                <option value="BMET–RAC">BMET–RAC - Bachelor of Mechanical Engineering Technology - Refrigeration and Air Conditioning</option>
                                <option value="BSIT–ADT">BSIT–ADT - Bachelor of Science in Industrial Technology - Automotive Design Technology</option>
                                <option value="BSIT–AT">BSIT–AT - Bachelor of Science in Industrial Technology - Automotive Technology</option>
                                <option value="BSIT–ELT">BSIT–ELT - Bachelor of Science in Industrial Technology - Electronics Technology</option>
                                <option value="BSIT–MT">BSIT–MT - Bachelor of Science in Industrial Technology - Mechanical Technology</option>
                                <option value="BSIT–WFT">BSIT–WFT - Bachelor of Science in Industrial Technology - Welding and Fabrication Technology</option>
                                <option value="BSIT–HVACR">BSIT–HVACR - Bachelor of Science in Industrial Technology - HVACR</option>
                                <option value="BSHM">BSHM - Bachelor of Science in Hospitality Management</option>
                                <option value="BSTM">BSTM - Bachelor of Science in Tourism Management</option>
                                <option value="BTVTED–FSM">BTVTED–FSM - Bachelor of Technical-Vocational Teacher Education - Food Service Management</option>
                                <option value="BSED–ENG">BSED–ENG - Bachelor of Secondary Education - English</option>
                                <option value="BSED–FIL">BSED–FIL - Bachelor of Secondary Education - Filipino</option>
                                <option value="BSED–MATH">BSED–MATH - Bachelor of Secondary Education - Mathematics</option>
                                <option value="BSED–SCI">BSED–SCI - Bachelor of Secondary Education - Science</option>
                                <option value="BEED">BEED - Bachelor of Elementary Education</option>
                                <option value="BPED">BPED - Bachelor of Physical Education</option>
                                <option value="BSES">BSES - Bachelor of Special Education</option>
                                <option value="BS Math">BS Math - Bachelor of Science in Mathematics</option>
                                <option value="BA-EL">BA-EL - Bachelor of Arts in English Language</option>
                            </select>
                        </div>
                        <div>
                            <label for="year_level">Year Level</label>
                            <select id="year_level" v-model="form.year_level" class="input-field" required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>


                        <!-- Address Section -->
                        <h3 class="section-heading">Address Information</h3>
                        <div>
                            <label for="address">Address (House No./Street)</label>
                            <input type="text" id="address" v-model="form.address" class="input-field" required />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                        <h3 class="section-heading">Parent Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                        <h3 class="section-heading">Socio-Economic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="housing_status">Housing Status</label>
                                <select id="housing_status" v-model="form.housing_status" class="input-field" required>
                                    <option value="">Select Housing Status</option>
                                    <option value="Owned">Owned</option>
                                    <option value="Renting">Renting</option>
                                    <option value="Living with Relatives">Living with Relatives</option>
                                </select>
                            </div>
                            <div>
                                <label for="monthly_rental">Monthly Boarding/Rental (PHP, if applicable)</label>
                                <input type="number" id="monthly_rental" v-model.number="form.monthly_rental" class="input-field" placeholder="e.g., 2500" />
                            </div>
                        </div>
                        
                        <!-- Status Checkboxes Section -->
                        <div class="checkbox-section">
                            <!-- Solo Parent Row -->
                            <div class="checkbox-row-with-input">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="is_solo_parent" v-model="form.is_solo_parent" class="checkbox-input" />
                                    <label for="is_solo_parent" class="checkbox-text">Are you a solo parent?</label>
                                </div>
                                <div v-if="form.is_solo_parent" class="conditional-input">
                                    <label for="solo_parent_id">Solo Parent ID No.</label>
                                    <input type="text" id="solo_parent_id" v-model="form.solo_parent_id" class="input-field" placeholder="Solo Parent ID" />
                                </div>
                            </div>
                            
                            <!-- Part-Time Job Row -->
                            <div class="checkbox-row-with-input">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="has_part_time_job" v-model="form.has_part_time_job" class="checkbox-input" />
                                    <label for="has_part_time_job" class="checkbox-text">Do you have a part-time job?</label>
                                </div>
                            </div>
                            
                            <!-- PWD Row -->
                            <div class="checkbox-row-with-input">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" id="pwd" v-model="form.pwd" class="checkbox-input" />
                                    <label for="pwd" class="checkbox-text">Are you a Person with Disability (PWD)?</label>
                                </div>
                                <div v-if="form.pwd" class="conditional-input">
                                    <label for="pwd_id">PWD ID Number</label>
                                    <input type="text" id="pwd_id" v-model="form.pwd_id" class="input-field" placeholder="PWD ID No." />
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="daily_fare">Daily Fare</label>
                                <select id="daily_fare" v-model="form.daily_fare" class="input-field">
                                    <option value="">Select Daily Fare</option>
                                    <option value="Php 20.00 - Php 50.00">Php 20.00 - Php 50.00</option>
                                    <option value="Php. 51.00 - Php 100.00">Php. 51.00 - Php 100.00</option>
                                    <option value="Php 101.00 - Php 200.00">Php 101.00 - Php 200.00</option>
                                    <option value="Php 201.00 - Php 300.00">Php 201.00 - Php 300.00</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>

                        <!-- Transportation & Ethnicity Section -->
                        <h3 class="section-heading">Transportation & Ethnicity</h3>
                        
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="transportation_mode">Mode of Transportation</label>
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
                                <label for="travel_time_minutes">Travel Time (Minutes)</label>
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
    marital_status: '', // Default value
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

/* ===== ENHANCED FORM INPUTS WITH DEPTH ===== */
.input-field {
    display: block;
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #2D3748;
    background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    transition: all 0.2s ease;
    box-sizing: border-box !important;
    /* Subtle inset shadow for depth */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.8) inset,
      0 2px 4px rgba(0, 0, 0, 0.04);
}

.input-field::placeholder {
    color: #a0aec0;
}

.input-field:hover {
    border-color: #cbd5e0;
    background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
}

.input-field:focus {
    outline: none;
    border-color: #235F23;
    background: linear-gradient(to bottom, #ffffff 0%, #f9f9f9 100%);
    /* Glowing effect on focus */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.9) inset,
      0 0 0 3px rgba(35, 95, 35, 0.1),
      0 2px 4px rgba(0, 0, 0, 0.05);
    transform: translateY(-1px);
}

label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-height: 2.5rem; /* Ensure consistent label height */
    line-height: 1.25rem;
}

/* ===== ENHANCED SUBMIT BUTTON WITH PROMINENCE ===== */
button[type="submit"] {
    width: 100%;
    padding: 16px 24px;
    background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%) !important;
    color: white !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 16px !important;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease !important;
    display: flex;
    justify-content: center;
    align-items: center;
    /* Small shadow for depth */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.2) inset,
      0 4px 8px rgba(35, 95, 35, 0.3),
      0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

button[type="submit"]:hover:not(:disabled) {
    background: linear-gradient(to bottom, #3a9a3a 0%, #2d7d2d 100%) !important;
    /* Bigger shadow on hover for prominence */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.3) inset,
      0 6px 12px rgba(35, 95, 35, 0.4),
      0 3px 6px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

button[type="submit"]:active:not(:disabled) {
    transform: translateY(0);
    /* Inset shadow to appear pressed */
    box-shadow: 
      0 2px 4px rgba(0, 0, 0, 0.2) inset,
      0 1px 2px rgba(0, 0, 0, 0.1) !important;
}

button[type="submit"]:disabled {
    background: linear-gradient(to bottom, #cbd5e0 0%, #a0aec0 100%) !important;
    cursor: not-allowed;
    box-shadow: none !important;
    transform: none;
}

/* ===== SECTION HEADINGS FOR BETTER HIERARCHY ===== */
.section-heading {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2D3748;
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ===== ENHANCED CHECKBOX SECTION ===== */
.checkbox-section {
    background: linear-gradient(to bottom, #f7fafc 0%, #edf2f7 100%);
    padding: 1.5rem;
    border-radius: 12px;
    margin: 1.5rem 0;
    /* Subtle depth */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.5) inset,
        0 2px 4px rgba(0, 0, 0, 0.03);
}

/* ===== ENHANCED CHECKBOX ROWS WITH INLINE INPUTS ===== */
.checkbox-row-with-input {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1rem;
    align-items: start; /* Align both items to top */
}

@media (max-width: 768px) {
    .checkbox-row-with-input {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    border-radius: 8px;
    transition: all 0.2s ease;
    /* Subtle shadow for depth */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.8) inset,
        0 2px 4px rgba(0, 0, 0, 0.04);
}

.checkbox-wrapper:hover {
    background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.9) inset,
        0 3px 6px rgba(0, 0, 0, 0.06);
    transform: translateY(-1px);
}

.conditional-input {
    display: flex;
    flex-direction: column;
    animation: slideIn 0.3s ease-out;
}

.conditional-input label {
    margin-bottom: 0.5rem;
    min-height: auto !important;
    font-size: 0.75rem;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    line-height: 1.2;
}

.conditional-input .input-field {
    /* No height override needed, let it be natural */
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.checkbox-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    margin-left: 0.75rem;
    margin-bottom: 0 !important;
    min-height: auto !important;
    line-height: 1.5rem;
    text-transform: none;
    letter-spacing: normal;
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

/* ===== ENHANCED CHECKBOX INPUTS ===== */
.checkbox-label {
    display: flex;
    align-items: center;
}

.checkbox-input {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #cbd5e0;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    appearance: none;
    flex-shrink: 0;
    background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    position: relative;
    /* Subtle inset shadow */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.8) inset,
        0 2px 4px rgba(0, 0, 0, 0.04);
}

.checkbox-input:hover {
    border-color: #a0aec0;
    background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
}

.checkbox-input:checked {
    background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
    border-color: #235F23;
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.2) inset,
        0 2px 4px rgba(35, 95, 35, 0.3);
}

/* Checkmark using ::after pseudo-element */
.checkbox-input:checked::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 0.75rem;
    height: 0.75rem;
    background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"%3E%3Cpolyline points="20 6 9 17 4 12"%3E%3C/polyline%3E%3C/svg%3E');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.checkbox-input:focus {
    outline: none;
    border-color: #235F23;
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.9) inset,
        0 0 0 3px rgba(35, 95, 35, 0.1);
}

/* ===== INPUT HELPER TEXT ===== */
.input-helper-text {
    font-size: 0.75rem;
    color: #718096;
    margin-top: 0.25rem;
    font-style: italic;
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

/* ===== ENHANCED LOGIN BUTTON IN NAVIGATION ===== */
.login-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 24px;
    background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
    color: white;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    /* Small shadow for depth */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.2) inset,
        0 4px 8px rgba(35, 95, 35, 0.3),
        0 2px 4px rgba(0, 0, 0, 0.1);
}

.login-button:hover {
    background: linear-gradient(to bottom, #3a9a3a 0%, #2d7d2d 100%);
    /* Bigger shadow on hover for prominence */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.3) inset,
        0 6px 12px rgba(35, 95, 35, 0.4),
        0 3px 6px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.login-button:active {
    transform: translateY(0);
    /* Inset shadow to appear pressed */
    box-shadow: 
        0 2px 4px rgba(0, 0, 0, 0.2) inset,
        0 1px 2px rgba(0, 0, 0, 0.1);
}

</style> 