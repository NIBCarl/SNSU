<template>
  <Head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </Head>
  <div class="container-1">
    <Transition name="slide-fade">
      <div v-if="isSidebarOpen" class="inner-container first-column">
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
        <div class="cta-button-dashboard">
          <i class="fas fa-plus not-circle"></i>
          <h1 class="cta-button-dashboard-head">Add new</h1>
          <p class="cta-text">Add new student info</p>
          <Link href="/add-new" class="button-1">Click here</Link>
        </div>
      </div>
    </Transition>

    <div class="inner-container second-column" :class="{ 'content-shifted': isSidebarOpen, 'content-full': !isSidebarOpen }">
      <div class="page-info flex items-center">
        <button @click="toggleSidebar" class="p-2 mr-4 text-gray-600 hover:text-gray-800 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Add new</h1>
        <div class="admin-setting flex">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input v-model="search" class="main-input" type="text" placeholder="Search" />
          </div>
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
          <div class="form-grid">
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
            <div class="form-group">
              <label>Student ID</label>
              <input v-model="form.student_id" type="text" required />
              <div v-if="errors.student_id" class="error">{{ errors.student_id }}</div>
            </div>
            <div class="form-group">
              <label>Address</label>
              <input v-model="form.address" type="text" required />
              <div v-if="errors.address" class="error">{{ errors.address }}</div>
            </div>
            <div class="form-group">
              <label>Barangay</label>
              <input v-model="form.barangay" type="text" required />
              <div v-if="errors.barangay" class="error">{{ errors.barangay }}</div>
            </div>
            <div class="form-group">
              <label>City</label>
              <input v-model="form.city" type="text" required />
              <div v-if="errors.city" class="error">{{ errors.city }}</div>
            </div>
            <div class="form-group">
              <label>Province</label>
              <input v-model="form.province" type="text" required />
              <div v-if="errors.province" class="error">{{ errors.province }}</div>
            </div>
            <div class="form-group">
              <label>Postal Code</label>
              <input v-model="form.postal_code" type="text" required />
              <div v-if="errors.postal_code" class="error">{{ errors.postal_code }}</div>
            </div>
            <div class="form-group">
              <label>Birth Date</label>
              <input v-model="form.birth_date" type="date" required />
              <div v-if="errors.birth_date" class="error">{{ errors.birth_date }}</div>
            </div>
            <div class="form-group">
              <label>Gender</label>
              <select v-model="form.gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
              <div v-if="errors.gender" class="error">{{ errors.gender }}</div>
            </div>
            <div class="form-group">
              <label>Course</label>
              <input v-model="form.course" type="text" required />
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
                <option value="Others">Others</option>
              </select>
              <div v-if="errors.year_level" class="error">{{ errors.year_level }}</div>
            </div>
            <div class="form-group">
              <label>Marital Status</label>
              <select v-model="form.marital_status" required>
                <option value="">Select Marital Status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
              </select>
              <div v-if="errors.marital_status" class="error">{{ errors.marital_status }}</div>
            </div>
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
            <div class="form-group">
              <label>Study Device</label>
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
              <label>Solo Parent</label>
              <div class="custom-control custom-switch">
                <input type="checkbox" v-model="form.is_solo_parent" class="custom-control-input" id="soloParent">
                <label class="custom-control-label" for="soloParent">Yes</label>
              </div>
              <input v-if="form.is_solo_parent" v-model="form.solo_parent_id" type="text" placeholder="Solo Parent ID No." />
              <div v-if="errors.is_solo_parent" class="error">{{ errors.is_solo_parent }}</div>
              <div v-if="errors.solo_parent_id" class="error">{{ errors.solo_parent_id }}</div>
            </div>
            <div class="form-group">
              <label>Part-time Job</label>
              <div class="custom-control custom-switch">
                <input type="checkbox" v-model="form.has_part_time_job" class="custom-control-input" id="partTimeJob">
                <label class="custom-control-label" for="partTimeJob">Yes</label>
              </div>
              <div v-if="errors.has_part_time_job" class="error">{{ errors.has_part_time_job }}</div>
            </div>
            <div class="form-group">
              <label>Daily Transportation Fare</label>
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
              <label>Monthly Rental Cost (if renting)</label>
              <input v-model="form.monthly_rental" type="number" min="0" step="0.01" />
              <div v-if="errors.monthly_rental" class="error">{{ errors.monthly_rental }}</div>
            </div>
            <div class="form-group">
              <label>Household Size</label>
              <input v-model="form.household_size" type="number" min="1" required />
              <div v-if="errors.household_size" class="error">{{ errors.household_size }}</div>
            </div>
            <div class="form-group">
              <label>Transportation Mode</label>
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
              <label>Travel Time (minutes)</label>
              <input v-model="form.travel_time_minutes" type="number" min="0" required />
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
            <div class="form-group">
              <label>Person with Disability (PWD)</label>
              <div class="custom-control custom-switch">
                <input type="checkbox" v-model="form.pwd" class="custom-control-input" id="pwd">
                <label class="custom-control-label" for="pwd">Yes</label>
              </div>
              <input v-if="form.pwd" v-model="form.pwd_id" type="text" placeholder="PWD ID No." />
              <div v-if="errors.pwd" class="error">{{ errors.pwd }}</div>
              <div v-if="errors.pwd_id" class="error">{{ errors.pwd_id }}</div>
            </div>
            <div class="form-group">
              <label>Housing Status</label>
              <select v-model="form.housing_status" required>
                <option value="">Select Housing Status</option>
                <option value="Owned">Owned</option>
                <option value="Renting">Renting</option>
                <option value="Living with Relatives">Living with Relatives</option>
                <option value="Other">Other</option>
              </select>
              <div v-if="errors.housing_status" class="error">{{ errors.housing_status }}</div>
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
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

// Sidebar toggle state and function
const isSidebarOpen = ref(true);
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

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
const search = ref(''); // For the search bar in the header
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
.search-bar {
    border: 0.5px solid #E2E8F0;
    border-radius: 15px;
    padding: 8.5px 13px;
    margin-right: 56px;
}
.fas.fa-search {
    color: #2D3748;
    padding-right: 12.68px;
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
.add-student-info {
    padding: 28px 32px;
    box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
    border-radius: 12px;
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
.cta-button-dashboard {
    padding: 16px;
    background-color: #235F23;
    border-radius: 15px;
    margin-top: 85px;

}
.button-1 {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    border: none;
    padding: 4.68px 40.5px;
    border-radius: 12px;
}
.cta-button-dashboard-head {
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;

}
.cta-text {
    font-size: 12px;
    font-weight: 400;
    color: #ffffff;
}
.cta-button-dashboard .fas.fa-plus {
    border-radius: 12px;
    font-size: 24px;
    margin-bottom: 21px;
    color: #235F23;
    background-color: #ffffff;
    padding: 12px;
}
h2 {
    margin-bottom: 15px;
    font-size: 18px;
    color: #2D3748;
    line-height: 25.02px;
    font-weight: 700;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.row input[type="text"],
.row input[type="number"],
.row input[type="tel"],
select {
    flex: 1;
    margin-right: 10px;
    margin-bottom: 10px;
    padding: 19px;
    border: 1px solid #ccc;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
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
    align-items: center;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
}

input[type="radio"] {
    margin-right: 5px;
}

.button-add {
    text-align: center;
    padding: 17px 52px;
    background-color: #235F23;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
    display: inline-block;
    border-radius: 15px;
}
.button-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.button-add:hover {
    background-color: #04AA6D;
}
.cog-icon {
    font-size: 15px;
    cursor: pointer;
}
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
}
.profile-picture .avatar {
    font-size: 50px;
    color: #006400;
    margin-bottom: 10px;
}
h2 {
    font-size: 18px;
}
p {
    font-size: 16px;
    color: black;
    margin-bottom: 15px;
    font-weight: bold;
}
.sign-out {
    color: red;
    text-decoration: none;
    font-size: 18px;
}

.sign-out:hover {
    text-decoration: underline;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 5px;
    color: #2D3748;
    font-weight: 500;
}

.form-group input,
.form-group select {
    padding: 8px;
    border: 1px solid #E2E8F0;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
}

.error {
    color: #e53e3e;
    font-size: 12px;
    margin-top: 2px;
}

.button-add {
    background-color: #235F23;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
}

.button-add:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.button-container {
    text-align: right;
    margin-top: 20px;
}

/* Responsive Form Grid */
@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
}

/* Responsive adjustments for columns */
@media (max-width: 768px) { 
  .container-1 {
    flex-direction: column;
    padding: 0.5rem;
    gap: 0.5rem;
  }
  .first-column {
    width: 100%; 
    margin-bottom: 1rem; 
  }
  .second-column {
    width: 100%;
    padding: 0.5rem;
  }
  .page-info {
    flex-direction: column;
    align-items: flex-start; 
  }
  .admin-setting {
    width: 100%;
    margin-top: 1rem;
    flex-direction: column;
    align-items: stretch;
  }
  .search-bar {
    width: 100%;
    margin-right: 0; 
    margin-bottom: 0.5rem; 
  }
  .admin-icons {
    justify-content: flex-start;
    margin-top: 0.5rem;
  }
}

/* Transition styles */
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(-280px); /* Slide out to the left, matches desktop sidebar width */
  opacity: 0;
}

/* Adjust second-column based on sidebar visibility for desktop */
.content-full {
  width: 100%;
  margin-left: 0; /* Ensures it takes full width when sidebar is gone */
}
.content-shifted {
  /* Flexbox handles the width adjustment of the second column when the first column is present.
     No explicit margin or width needed here if .container-1 is display:flex 
     and .first-column has a fixed width and .second-column has flex-grow:1. */
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