<template>
  <Head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </Head>
  <div class="container-1">
    <!-- Mobile Overlay Backdrop -->
    <div v-if="isSidebarOpen" @click="toggleSidebar" class="sidebar-backdrop"></div>
    
    <!-- Sidebar -->
    <Transition name="slide-fade">
      <div v-if="isSidebarOpen" class="inner-container first-column sidebar-menu">
        <div class="logo-sec">
          <img class="logo" src="/assets/logo.png" alt="University logo" />
          <h1 class="logo-text">Dashboard</h1>
        </div>
        <div class="separator">
          <hr class="solid" />
        </div>
        <div class="dashboard-list">
          <div class="not-flex">
            <Link href="/dashboard" class="dashboard"><i class="fas fa-home"></i>Dashboard</Link>
            <Link href="/student-list" class="dashboard"><i class="fas fa-bar-chart"></i>Student Lists</Link>
            <Link href="/add-new" class="lists"><i class="fas fa-plus"></i>Add new</Link>
          </div>
        </div>
        <AddNewCTA />
      </div>
    </Transition>

    <div class="inner-container second-column" :class="{ 'content-shifted': isSidebarOpen, 'content-full': !isSidebarOpen }">
      <div class="page-info flex items-center">
        <button @click="toggleSidebar" class="hamburger-button">
          <svg class="hamburger-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Add new</h1>
        <div class="admin-setting flex">
          <ul class="admin-icons flex">
            <Link href="/profile" class="admin">
              <i class="fas fa-user admin-user-icon"></i>admin
            </Link>
            <div class="cog-icon" @click="toggleModal">⚙️</div>
            <div v-if="showModal" class="modal" id="modal">
              <div class="modal-content">
                <span class="close" @click="toggleModal">&times;</span>
                <div class="profile-picture">
                  <div class="avatar">
                    <i class="fas fa-user-circle"></i>
                  </div>
                </div>
                <h2>Admin</h2>
                <p>studentaffairs@ssct.edu.ph</p>
                <Link href="/logout" method="post" as="button" class="sign-out">Sign out</Link>
              </div>
            </div>
          </ul>
        </div>
      </div>

      <div class="add-student-info">
        <form @submit.prevent="submitForm">
          <h2>Student Information</h2>
          
          <!-- Personal Information Section -->
          <h3 class="section-title">Personal Information</h3>
          <div class="form-row-3">
            <div class="form-group">
              <label>First Name</label>
              <input v-model="form.first_name" type="text" required />
              <div v-if="errors.first_name" class="error">{{ errors.first_name }}</div>
            </div>
            <div class="form-group">
              <label>Middle Name</label>
              <input v-model="form.middle_name" type="text" />
              <div v-if="errors.middle_name" class="error">{{ errors.middle_name }}</div>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input v-model="form.last_name" type="text" required />
              <div v-if="errors.last_name" class="error">{{ errors.last_name }}</div>
            </div>
          </div>

          <div class="form-row-2">
            <div class="form-group">
              <label>Student ID</label>
              <input 
                v-model="form.student_id" 
                type="text" 
                pattern="\d{4}-\d{5}"
                placeholder="2023-01292"
                title="Format: YYYY-##### (e.g., 2023-01292)"
                required 
              />
              <p class="input-helper-text">Format: YYYY-##### (e.g., 2023-01292)</p>
              <div v-if="errors.student_id" class="error">{{ errors.student_id }}</div>
            </div>
            <div class="form-group">
              <label>Birth Date</label>
              <input v-model="form.birth_date" type="date" required />
              <div v-if="errors.birth_date" class="error">{{ errors.birth_date }}</div>
            </div>
          </div>

          <div class="form-row-2">
            <div class="form-group">
              <label>Gender</label>
              <select v-model="form.gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <div v-if="errors.gender" class="error">{{ errors.gender }}</div>
            </div>
            <div class="form-group">
              <label>Marital Status</label>
              <select v-model="form.marital_status" required>
                <option value="">Select Marital Status</option>
                <option value="Single (Never Married)">Single (Never Married)</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Divorced">Divorced</option>
                <option value="Separated">Separated</option>
              </select>
              <div v-if="errors.marital_status" class="error">{{ errors.marital_status }}</div>
            </div>
          </div>

          <div class="form-row-2">
            <div class="form-group">
              <label>Religion</label>
              <input v-model="form.religion" type="text" required />
              <div v-if="errors.religion" class="error">{{ errors.religion }}</div>
            </div>
            <div class="form-group">
              <label>Cellphone Number</label>
              <input v-model="form.cellphone_number" type="tel" required />
              <div v-if="errors.cellphone_number" class="error">{{ errors.cellphone_number }}</div>
            </div>
          </div>

          <!-- Academic Information Section -->
          <h3 class="section-title">Academic Information</h3>
          <div class="form-group">
            <label>Course</label>
            <select v-model="form.course" required>
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
            <div v-if="errors.course" class="error">{{ errors.course }}</div>
          </div>
          <div class="form-group">
            <label>Year Level</label>
            <select v-model="form.year_level" required>
              <option value="">Select Year Level</option>
              <option value="1st Year">1st Year</option>
              <option value="2nd Year">2nd Year</option>
              <option value="3rd Year">3rd Year</option>
              <option value="4th Year">4th Year</option>
            </select>
            <div v-if="errors.year_level" class="error">{{ errors.year_level }}</div>
          </div>

          <!-- Address Section -->
          <h3 class="section-title">Address</h3>
          <div class="form-group">
            <label>Address (House No./Street)</label>
            <input v-model="form.address" type="text" required />
            <div v-if="errors.address" class="error">{{ errors.address }}</div>
          </div>
          <div class="form-row-3">
            <div class="form-group">
              <label>Barangay</label>
              <input v-model="form.barangay" type="text" required />
              <div v-if="errors.barangay" class="error">{{ errors.barangay }}</div>
            </div>
            <div class="form-group">
              <label>City/Municipality</label>
              <input v-model="form.city" type="text" required />
              <div v-if="errors.city" class="error">{{ errors.city }}</div>
            </div>
            <div class="form-group">
              <label>Province</label>
              <input v-model="form.province" type="text" required />
              <div v-if="errors.province" class="error">{{ errors.province }}</div>
            </div>
          </div>
          <div class="form-group">
            <label>Postal Code</label>
            <input v-model="form.postal_code" type="text" required />
            <div v-if="errors.postal_code" class="error">{{ errors.postal_code }}</div>
          </div>

          <!-- Parent Information Section -->
          <h3 class="section-title">Parent Information</h3>
          <div class="form-row-3">
            <div class="form-group">
              <label>Father's Name</label>
              <input v-model="form.father_name" type="text" required />
              <div v-if="errors.father_name" class="error">{{ errors.father_name }}</div>
            </div>
            <div class="form-group">
              <label>Mother's Name</label>
              <input v-model="form.mother_name" type="text" required />
              <div v-if="errors.mother_name" class="error">{{ errors.mother_name }}</div>
            </div>
            <div class="form-group">
              <label>Family Income (Monthly Gross)</label>
              <select v-model="form.family_income" required>
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
              <div v-if="errors.family_income" class="error">{{ errors.family_income }}</div>
            </div>
          </div>

          <!-- Socio-Economic Information Section -->
          <h3 class="section-title">Socio-Economic Information</h3>
          <div class="form-row-2">
            <div class="form-group">
              <label>Primary Study Device</label>
              <select v-model="form.study_device" required>
                <option value="">Select Study Device</option>
                <option value="Laptop">Laptop</option>
                <option value="Tablet">Tablet</option>
                <option value="Desktop">Desktop</option>
                <option value="Mobile Phone">Mobile Phone</option>
              </select>
              <div v-if="errors.study_device" class="error">{{ errors.study_device }}</div>
            </div>
            <div class="form-group">
              <label>Household Size</label>
              <input v-model="form.household_size" type="number" min="1" required />
              <div v-if="errors.household_size" class="error">{{ errors.household_size }}</div>
            </div>
          </div>

          <div class="form-row-2">
            <div class="form-group">
              <label>Housing Status</label>
              <select v-model="form.housing_status" required>
                <option value="">Select Housing Status</option>
                <option value="Owned">Owned</option>
                <option value="Renting">Renting</option>
                <option value="Living with Relatives">Living with Relatives</option>
              </select>
              <div v-if="errors.housing_status" class="error">{{ errors.housing_status }}</div>
            </div>
          </div>

          <!-- Status Checkboxes Section -->
          <div class="checkbox-section">
            <!-- Solo Parent Row -->
            <div class="checkbox-row-with-input">
              <div class="checkbox-wrapper">
                <input type="checkbox" v-model="form.is_solo_parent" class="checkbox-input" id="soloParent">
                <label class="checkbox-text" for="soloParent">Are you a solo parent?</label>
                <div v-if="errors.is_solo_parent" class="error">{{ errors.is_solo_parent }}</div>
              </div>
              <div v-if="form.is_solo_parent" class="conditional-input">
                <label for="solo_parent_id">Solo Parent ID No.</label>
                <input v-model="form.solo_parent_id" type="text" placeholder="Solo Parent ID No." />
                <div v-if="errors.solo_parent_id" class="error">{{ errors.solo_parent_id }}</div>
              </div>
            </div>
            
            <!-- Part-Time Job Row -->
            <div class="checkbox-row-with-input">
              <div class="checkbox-wrapper">
                <input type="checkbox" v-model="form.has_part_time_job" class="checkbox-input" id="partTimeJob">
                <label class="checkbox-text" for="partTimeJob">Do you have a part-time job?</label>
                <div v-if="errors.has_part_time_job" class="error">{{ errors.has_part_time_job }}</div>
              </div>
            </div>
            
            <!-- PWD Row -->
            <div class="checkbox-row-with-input">
              <div class="checkbox-wrapper">
                <input type="checkbox" v-model="form.pwd" class="checkbox-input" id="pwd">
                <label class="checkbox-text" for="pwd">Are you a Person with Disability (PWD)?</label>
                <div v-if="errors.pwd" class="error">{{ errors.pwd }}</div>
              </div>
              <div v-if="form.pwd" class="conditional-input">
                <label for="pwd_id">PWD ID Number</label>
                <input v-model="form.pwd_id" type="text" placeholder="PWD ID No." />
                <div v-if="errors.pwd_id" class="error">{{ errors.pwd_id }}</div>
              </div>
            </div>
          </div>

          <div class="form-row-2">
            <div class="form-group">
              <label>Daily Fare (PHP)</label>
              <select v-model="form.daily_fare">
                <option value="">Select Daily Fare</option>
                <option value="Php 20.00 - Php 50.00">Php 20.00 - Php 50.00</option>
                <option value="Php. 51.00 - Php 100.00">Php. 51.00 - Php 100.00</option>
                <option value="Php 101.00 - Php 200.00">Php 101.00 - Php 200.00</option>
                <option value="Php 201.00 - Php 300.00">Php 201.00 - Php 300.00</option>
                <option value="N/A">N/A</option>
              </select>
              <div v-if="errors.daily_fare" class="error">{{ errors.daily_fare }}</div>
            </div>
            <div class="form-group">
              <label>Monthly Boarding/Rental (PHP, if applicable)</label>
              <input v-model="form.monthly_rental" type="number" min="0" step="0.01" placeholder="e.g., 2500" />
              <div v-if="errors.monthly_rental" class="error">{{ errors.monthly_rental }}</div>
            </div>
          </div>

          <!-- Transportation & Ethnicity Section -->
          <h3 class="section-title">Transportation & Ethnicity</h3>
          <div class="form-row-3">
            <div class="form-group">
              <label>Mode of Transportation to School</label>
              <select v-model="form.transportation_mode" required>
                <option value="">Select Transportation</option>
                <option value="Car">Car</option>
                <option value="Jeep/Multicab">Jeep/Multicab</option>
                <option value="Motorcycle">Motorcycle</option>
                <option value="Tricycle">Tricycle</option>
                <option value="None">None</option>
              </select>
              <div v-if="errors.transportation_mode" class="error">{{ errors.transportation_mode }}</div>
            </div>
            <div class="form-group">
              <label>Travel Time to School (minutes)</label>
              <input v-model="form.travel_time_minutes" type="number" min="0" placeholder="e.g., 30" required />
              <div v-if="errors.travel_time_minutes" class="error">{{ errors.travel_time_minutes }}</div>
            </div>
            <div class="form-group">
              <label>Ethnicity</label>
              <select v-model="form.ethnicity" required>
                <option value="">Select Ethnicity</option>
                <option value="Indigenous">Indigenous</option>
                <option value="Non-Indigenous">Non-Indigenous</option>
              </select>
              <div v-if="errors.ethnicity" class="error">{{ errors.ethnicity }}</div>
            </div>
          </div>

          <div class="button-container">
            <button type="submit" class="button-add" :disabled="processing">
              {{ processing ? 'Submitting...' : 'Submit' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AddNewCTA from '@/Components/AddNewCTA.vue';

// Sidebar toggle state and function with mobile detection
const isMobile = ref(window.innerWidth <= 768);
const isSidebarOpen = ref(window.innerWidth > 768); // Open by default on desktop, closed on mobile

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

// Handle window resize
const handleResize = () => {
  isMobile.value = window.innerWidth <= 768;
  // Auto-open sidebar on desktop, auto-close on mobile when resizing
  if (window.innerWidth > 768) {
    isSidebarOpen.value = true;
  } else {
    isSidebarOpen.value = false;
  }
};

onMounted(() => {
  window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});

// Props
defineProps({
  errors: {
    type: Object,
    default: () => ({})
  },
  auth: {
    type: Object,
    default: () => ({})
  }
});

// Existing reactive variables for this page
const showModal = ref(false); // For the admin profile modal
const processing = ref(false); // For form submission state

// Student Information Form definition
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
  monthly_rental: null, // Use null for numbers that can be empty
  father_name: '',
  mother_name: '',
  household_size: null, // Use null for numbers that can be empty
  transportation_mode: '',
  travel_time_minutes: null, // Use null for numbers that can be empty
  ethnicity: '',
  pwd: false,
  pwd_id: '',
  housing_status: '',
  family_income: ''
});

// Method to toggle the admin profile modal
const toggleModal = () => {
  showModal.value = !showModal.value;
};

// Method to submit the student form
const submitForm = () => {
  processing.value = true;
  form.post('/student', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      processing.value = false;
      // Consider using Inertia.visit for navigation to ensure SPA behavior
      // Inertia.visit('/student-list'); 
      window.location.href = '/student-list'; // Current redirect method
    },
    onError: () => {
      processing.value = false;
      // Errors are automatically available in form.errors
    }
  });
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Poppins');

* {
    margin: 0;
    padding: 0;
    font-family: 'Poppins';
}
body {
    width: 100%;
}
.container-1 {
    padding: 1rem;
    width: 100%; 
    min-height: 100vh; 
    display: flex;
    background-color: #F8F9FA;
    gap: 1rem; 
    position: relative; 
}
.flex { display: flex; }

.inner-container {
    width: 1920px;
    
}
.logo-sec {
    display: flex;
    align-items: center;
}
.logo {
    width: 37px;
    height: 37px;
    object-fit: contain;
}
.logo-text{
    color: #2D3748;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    padding-left: 12px;
}
.first-column {
    flex-shrink: 0; 
    width: 280px; 
    padding: 1rem; 
    background-color: white; /* Added for consistency if other sidebars are white */
    border-radius: 15px; /* Optional: if matching other sidebar styles */
    box-shadow: 0 0 10px rgba(0,0,0,0.05); /* Optional subtle shadow */
}
.second-column {
    flex-grow: 1; 
    padding: 1rem; 
    overflow-x: auto; 
    background-color: white; /* Added for consistency */
    border-radius: 15px; /* Optional */
    box-shadow: 0 0 10px rgba(0,0,0,0.05); /* Optional */
}
.gray {
    color: #A0AEC0;
}
.main-title {
    font-size: 32px;
    font-weight: 400;
}
/* ===== ENHANCED HAMBURGER BUTTON ===== */
.hamburger-button {
    padding: 0.625rem;
    margin-right: 1rem;
    background: linear-gradient(to bottom, #ffffff 0%, #f8f8f8 100%);
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    /* Layered shadows for depth */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.8) inset,
        0 2px 4px rgba(0, 0, 0, 0.06);
}

.hamburger-button:hover {
    background: linear-gradient(to bottom, #f8f8f8 0%, #f0f0f0 100%);
    border-color: #235F23;
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.9) inset,
        0 4px 8px rgba(0, 0, 0, 0.1),
        0 0 0 2px rgba(35, 95, 35, 0.1);
    transform: translateY(-1px);
}

.hamburger-button:active {
    transform: translateY(0);
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.7) inset,
        0 1px 2px rgba(0, 0, 0, 0.1);
}

.hamburger-button:focus {
    outline: none;
}

.hamburger-icon {
    width: 1.5rem;
    height: 1.5rem;
    color: #4a5568;
    transition: color 0.2s ease;
}

.hamburger-button:hover .hamburger-icon {
    color: #235F23;
}

.page-info {
    justify-content: space-between;
    align-items: center;
    padding: 0 0 42.5px 0;
}
.main-input {
    border: 0;
    color: #A0AEC0;
    font-size: 12px;
}
.admin-setting {
    align-items: center;
}
.admin-user-icon, .fa-cog {
    font-size: 12px;
    color: #718096;
}
.admin {
    padding-right: 23px;
    font-size: 12px;
    font-weight: 700;
    color: #718096;
}
.admin-user-icon {
    padding-right: 4px;
}
ul {
    list-style-type: none;
}
.lists .fas.fa-plus {
    font-size: 15px;
    color: #ffffff;
    background-color: #235F23;
    border-radius: 12px;
    padding: 7.5px;
    margin-right: 11.5px;
}
.dashboard .fas.fa-home, 
.dashboard .fas.fa-bar-chart {
    font-size: 15px;
    color: #235F23;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 7.5px;
    margin-right: 11.5px;
}
.lists{
    font-size: 12px;
    font-weight: 700;
    color: #2D3748;
    padding: 12px 20px 12px 16px;
    border-radius: 15px;
    box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
}
.dashboard, .add-new {
    font-size: 12px;
    font-weight: 700;
    color: #A0AEC0;
    padding: 12px 20px 12px 16px;
    border-radius: 15px;
}
a:hover {
    text-decoration: none;
    color: #A0AEC0;
}
.dashboard:hover {
    color: #2D3748;
}
.not-flex {
    display: flex;
    flex-direction: column;
}
.total-icons {
    justify-content: space-between;
    align-items: center;
}
.total-cont {
    padding: 17.5px;
    box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
    align-items: center;
    border-radius: 12px;
    width: 382px;
    justify-content: space-between;
}
.sub-headline {
    color: #A0AEC0;
    font-size: 12px;
    font-weight: 700;
    line-height: 18px;
}
.headline-total {

    font-size: 18px;
    font-weight: 700;
    color: #2D3748;
    line-height: 25px;

}
.icon-design {
    color: #ffffff;
    background-color: #235F23;
    padding: 10px;
    border-radius: 8px;
    font-size: 21px;
}
h1 {
    margin: 0;
}
.dashboard-text {
    display: flex;
    column-gap: 20px;
    margin-top: 23.5px;
}
.dashboard-text-inner, .dashboard-text-inner-2 {
    display: flex;
    padding: 21px;
    box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    column-gap: 50px;
    
}
.img-dashboard-first {
    object-fit: contain;
    width: 285px;
    height: 277.68px;
}
.text-wrapper-2 {
    font-size: 18px;
    line-height: 26px;
    padding-bottom: 11px;
}
.p {
    color: #A0AEC0;
    font-size: 14px;
    padding-bottom: 73px;
}
.button {
    color: #2D3748;
    font-size: 20px;
    padding: 0;
    font-weight: 700;
    background-color: #ffffff00;
    border: none;
}
.overlap-group-2 {
    width: 502px;
}
.charlang {
    align-items: center;
    justify-content: center;
}
.text-wrapper-2-2 {
    font-size: 32px;
    font-weight: 500;
    color: #235F23;
}
.p-1 {
    color: #000000;
    font-size: 16px;

}
.dashboard-text-inner-2 {
    width: 804px;
}
.text-wrapper-2-socio {
    font-size: 16px;
    font-weight: 500;
}
.title-description-over {
    display: flex;  
    justify-content: flex-start;
}
/* ===== ENHANCED FORM CONTAINER WITH LAYERED DEPTH ===== */
.add-student-info {
    padding: 40px 48px;
    /* Lighter shade background - elevated from page */
    background: linear-gradient(to bottom, #ffffff 0%, #f7fafc 100%);
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    /* Medium shadow - prominent elevation */
    box-shadow: 
      0 2px 0 rgba(255, 255, 255, 0.9) inset,
      0 8px 16px rgba(0, 0, 0, 0.06),
      0 4px 8px rgba(0, 0, 0, 0.04),
      0 2px 4px rgba(0, 0, 0, 0.02);
}
.location-headline {
    font-size: 18px;
    font-weight: 700;
    color: #2D3748;
    margin-bottom: 6px;
}
.headline-overview-location {
    padding-bottom: 28px;
}

/* ===== ENHANCED MAIN HEADING WITH PROMINENCE ===== */
h2 {
    margin-bottom: 24px;
    font-size: 28px;
    color: #1a202c;
    line-height: 1.3;
    font-weight: 700;
    padding-bottom: 16px;
    border-bottom: 3px solid #e2e8f0;
    /* Dual shadow for depth - lighter shade above */
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    position: relative;
}

/* Accent line for emphasis */
h2::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 80px;
    height: 3px;
    background: linear-gradient(to right, #2d7d2d 0%, #38a169 100%);
    border-radius: 2px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

/* ===== ENHANCED FORM INPUTS WITH DEPTH ===== */
.row input[type="text"],
.row input[type="number"],
.row input[type="tel"],
select {
    flex: 1;
    margin-right: 10px;
    margin-bottom: 10px;
    padding: 14px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    color: #2D3748;
    background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    transition: all 0.2s ease;
    /* Subtle inset shadow for depth */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.8) inset,
      0 2px 4px rgba(0, 0, 0, 0.04);
}

.row input[type="text"]:focus,
.row input[type="number"]:focus,
.row input[type="tel"]:focus,
select:focus {
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

.row input[type="text"]:hover,
.row input[type="number"]:hover,
.row input[type="tel"]:hover,
select:hover {
    border-color: #cbd5e0;
    background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
}

.row input[type="text"]:last-child,
.row input[type="number"]:last-child,
.row input[type="tel"]:last-child,
select:last-child {
    margin-right: 0;
}

label {
    margin-right: 15px;
    display: flex;
    align-items: flex-start;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    min-height: 2.5rem; /* Ensure consistent label height for alignment */
    line-height: 1.25rem;
}

input[type="radio"] {
    margin-right: 5px;
}

/* ===== ENHANCED SUBMIT BUTTON WITH PROMINENCE ===== */
.button-add {
    text-align: center;
    padding: 16px 52px;
    background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-block;
    /* Small shadow for depth */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.2) inset,
      0 4px 8px rgba(35, 95, 35, 0.3),
      0 2px 4px rgba(0, 0, 0, 0.1);
}

.button-add:hover {
    background: linear-gradient(to bottom, #3a9a3a 0%, #2d7d2d 100%);
    /* Bigger shadow on hover for prominence */
    box-shadow: 
      0 1px 0 rgba(255, 255, 255, 0.3) inset,
      0 6px 12px rgba(35, 95, 35, 0.4),
      0 3px 6px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.button-add:active {
    transform: translateY(0);
    /* Inset shadow to appear pressed */
    box-shadow: 
      0 2px 4px rgba(0, 0, 0, 0.2) inset,
      0 1px 2px rgba(0, 0, 0, 0.1);
}
/* button-container style consolidated below */
.cog-icon {
    font-size: 15px;
    cursor: pointer;
}

/* ===== ENHANCED SETTINGS MODAL (Admin Profile) ===== */
.modal {
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    border-radius: 15px;
    padding: 30px;
    width: 300px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #4A5568;
}

.close:hover {
    color: #2D3748;
}

.profile-picture {
    margin-bottom: 15px;
}

.profile-picture .avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #2d7d2d 0%, #235F23 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    box-shadow: 
        0 4px 12px rgba(35, 95, 35, 0.3),
        0 2px 4px rgba(0, 0, 0, 0.1);
}

.profile-picture .avatar i {
    font-size: 40px;
    color: #ffffff;
}

.modal-content h2 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #2D3748;
    font-weight: 600;
}

.modal-content p {
    font-size: 14px;
    color: #4A5568;
    margin-bottom: 20px;
    font-weight: 500;
}

.sign-out {
    color: #e53e3e;
    text-decoration: none;
    font-size: 16px;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    padding: 8px 24px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.sign-out:hover {
    background-color: #fff5f5;
    text-decoration: none;
}

/* ===== ENHANCED SECTION TITLES WITH LAYERING ===== */
.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1a202c;
    margin-top: 32px;
    margin-bottom: 20px;
    padding: 12px 16px;
    /* Lighter shade background to elevate */
    background: linear-gradient(to right, #f7fafc 0%, #ffffff 100%);
    border-left: 4px solid #2d7d2d;
    border-radius: 6px;
    /* Small shadow for depth */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.8) inset,
        0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.form-row-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 16px;
}

.form-row-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}

.form-group label {
    margin-bottom: 8px;
    color: #2D3748;
    font-weight: 500;
    font-size: 18px;
    min-height: 2.5rem; /* Ensure consistent label height for alignment */
    line-height: 1.25rem;
    display: flex;
    align-items: flex-start;
}

/* ===== ENHANCED FORM INPUTS WITH DUAL SHADOWS ===== */
.form-group input,
.form-group select {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
    background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
    color: #2d3748;
    font-weight: 500;
    transition: all 0.2s ease;
    /* Dual shadow: light top inset + dark bottom outset */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.8) inset,
        0 2px 4px rgba(0, 0, 0, 0.04);
}

.form-group input:hover,
.form-group select:hover {
    border-color: #cbd5e0;
    background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #2d7d2d;
    /* Medium shadow for prominence on focus */
    box-shadow: 
        0 1px 0 rgba(255, 255, 255, 0.9) inset,
        0 0 0 3px rgba(45, 125, 45, 0.1),
        0 4px 6px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

/* ===== ENHANCED CHECKBOX SECTIONS WITH LAYERING ===== */
.checkbox-section {
    margin-bottom: 1.5rem;
    padding: 1.5rem;
    border-radius: 10px;
    /* Darker shade to de-emphasize - pushed deeper */
    background: linear-gradient(to bottom, #f7fafc 0%, #edf2f7 100%);
    border: 1px solid #e2e8f0;
    /* Inset shadow for depth - appears recessed */
    box-shadow: 
        0 2px 4px rgba(0, 0, 0, 0.04) inset,
        0 1px 0 rgba(255, 255, 255, 0.5);
}

/* ===== ENHANCED CHECKBOX ROWS WITH INLINE INPUTS ===== */
.checkbox-row-with-input {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1rem;
    align-items: start; /* Align both items to top */
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

.conditional-input input {
    /* Input inherits styles from form-group input */
    width: 100%;
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
    cursor: pointer;
    margin: 0;
    margin-left: 0.75rem;
    user-select: none;
    transition: color 0.2s ease;
}

.checkbox-text:hover {
    color: #235F23;
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

.error {
    color: #e53e3e;
    font-size: 12px;
    margin-top: 2px;
}

/* ===== INPUT HELPER TEXT ===== */
.input-helper-text {
    font-size: 0.75rem;
    color: #718096;
    margin-top: 0.25rem;
    font-style: italic;
}

/* Button styles consolidated above - duplicate removed */

.button-add:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    /* Inset shadow to appear depressed when disabled */
    box-shadow: 
      0 2px 4px rgba(0, 0, 0, 0.1) inset;
    transform: none;
}

.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 2px solid #e2e8f0;
}

/* ===== ENHANCED RESPONSIVE DESIGN - REARRANGING WITH PURPOSE ===== */
@media (max-width: 768px) {
  /* Form container - reduce padding but maintain depth */
  .add-student-info {
    padding: 24px 20px;
    border-radius: 12px;
  }
  
  /* Main heading - maintain prominence */
  h2 {
    font-size: 24px;
    margin-bottom: 20px;
    padding-bottom: 12px;
  }
  
  h2::after {
    width: 60px;
  }
  
  /* Section titles - flow better on mobile */
  .section-title {
    font-size: 16px;
    margin-top: 24px;
    margin-bottom: 16px;
    padding: 10px 12px;
  }
  
  /* Form grids - stack vertically with clear spacing */
  .form-row-2,
  .form-row-3 {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  /* Labels - adjust for mobile */
  .form-group label {
    font-size: 16px;
    min-height: auto;
  }
  
  /* Inputs - maintain depth on mobile */
  .form-group input,
  .form-group select {
    padding: 14px;
    font-size: 16px; /* Prevent zoom on iOS */
  }
  
  /* Checkbox sections - reprioritize */
  .checkbox-row-with-input {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .checkbox-section {
    padding: 1rem;
    margin-bottom: 1rem;
  }
  
  /* Button - full width for easier tapping */
  .button-container {
    margin-top: 24px;
    padding-top: 20px;
  }
  
  .button-add {
    width: 100%;
    padding: 16px 24px;
    font-size: 16px;
  }
}

/* ===== MOBILE SIDEBAR AS OVERLAY ===== */
@media (max-width: 768px) { 
  .container-1 {
    position: relative;
    flex-direction: row; /* Keep row to allow overlay */
    padding: 0;
    gap: 0;
  }
  
  /* Sidebar as overlay on mobile */
  .first-column.sidebar-menu {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    max-width: 85vw;
    margin: 0;
    z-index: 1000;
    overflow-y: auto;
    /* Enhanced shadow for prominence */
    box-shadow: 
      0 10px 40px rgba(0, 0, 0, 0.2),
      0 4px 12px rgba(0, 0, 0, 0.15);
  }
  
  /* Backdrop overlay */
  .sidebar-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    animation: fadeIn 0.3s ease;
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }
  
  /* Content takes full width on mobile */
  .second-column {
    width: 100% !important;
    padding: 0.5rem;
    margin-left: 0 !important;
  }
  
  .page-info {
    flex-direction: row;
    align-items: center;
    flex-wrap: wrap;
  }
  
  .main-title {
    font-size: 20px;
    flex: 1;
  }
  
  .admin-setting {
    width: 100%;
    margin-top: 1rem;
    flex-direction: column;
    align-items: stretch;
  }
  
  .admin-icons {
    justify-content: flex-start;
    margin-top: 0.5rem;
  }
  
  /* Ensure hamburger is always visible on mobile */
  .hamburger-button {
    display: flex !important;
    margin-right: 0.75rem;
  }
}

/* ===== IMPROVED SIDEBAR TRANSITION ===== */
.slide-fade-enter-active {
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.slide-fade-leave-active {
  transition: transform 0.25s cubic-bezier(0.4, 0, 1, 1);
}

.slide-fade-enter-from {
  transform: translateX(-100%);
}

.slide-fade-leave-to {
  transform: translateX(-100%);
}

/* Desktop: No transform needed */
@media (min-width: 769px) {
  .slide-fade-enter-from,
  .slide-fade-leave-to {
    transform: translateX(0);
    opacity: 0;
  }
  
  /* Hide backdrop on desktop */
  .sidebar-backdrop {
    display: none;
  }
}

/* Adjust second-column based on sidebar visibility for desktop */
.content-full {
  width: 100%;
  margin-left: 0; /* Ensures it takes full width when sidebar is gone */
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth expansion */
}

.content-shifted {
  /* Flexbox handles the width adjustment of the second column when the first column is present.
     No explicit margin or width needed here if .container-1 is display:flex 
     and .first-column has a fixed width and .second-column has flex-grow:1. */
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth transition */
}

/* General Font Awesome Styles - Crucial for rendering */
i.fas, i.far, i.fab {
  font-family: "Font Awesome 6 Free" !important; 
  font-style: normal !important; 
  display: inline-block;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
}

i.fas { /* Solid icons */
  font-weight: 900 !important; 
}

i.far { /* Regular icons */
  font-weight: 400 !important; 
}

i.fab {
    font-weight: 400 !important; 
}
</style>