<template>
  <div class="container-1">
    <Transition name="slide-fade">
      <div v-if="isSidebarOpen" class="inner-container first-column">
        <div class="logo-sec">
          <img class="logo" src="/assets/logo.png" alt="University logo">
          <h1 class="logo-text">Dashboard</h1>
        </div>
        <div class="separator">
          <hr class="solid">
        </div>
        <div class="dashboard-list">
          <div class="not-flex">
            <Link href="/dashboard" class="dashboard"><i class="fas fa-home"></i>Dashboard</Link>
            <Link href="/student-list" class="lists"><i class="fas fa-bar-chart"></i>Student Lists</Link>
            <Link href="/add-new" class="add-new"><i class="fas fa-plus"></i>Add new</Link>
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
      <!-- Flash Message / Toast Notification -->
      <div v-if="displayFlashMessage && flashMessageContent" 
           class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="p-6 rounded-lg shadow-xl text-center text-white max-w-sm mx-auto"
             :class="flashMessageType === 'success' ? 'bg-green-600' : 'bg-red-600'">
          <div class="flex justify-between items-center mb-3">
            <span class="font-semibold text-lg">{{ flashMessageType === 'success' ? 'Success' : 'Error' }}</span>
            <button @click="dismissFlashMessage" class="text-2xl font-semibold leading-none hover:text-gray-200">&times;</button>
          </div>
          <p>{{ flashMessageContent }}</p>
        </div>
      </div>

      <div class="page-info flex items-center">
        <button @click="toggleSidebar" class="p-2 mr-4 text-gray-600 hover:text-gray-800 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Student List</h1>
        <div class="admin-setting flex">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input v-model="search" class="main-input" type="text" placeholder="Search students..." @input="handleFilters" />
          </div>
        </div>
      </div>

      <!-- Advanced Filters Section -->
      <div class="filters-section">
        <div class="filters-header">
          <h3 class="filters-title">
            <i class="fas fa-filter"></i> Filters
            <span v-if="activeFiltersCount > 0" class="active-filters-badge">{{ activeFiltersCount }}</span>
          </h3>
          <button @click="toggleFilters" class="toggle-filters-btn">
            {{ showFilters ? 'Hide Filters' : 'Show Filters' }}
            <i :class="showFilters ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
          </button>
        </div>
        
        <Transition name="filter-slide">
          <div v-if="showFilters" class="filters-grid">
            <div class="filter-item">
              <label class="filter-label">Course</label>
              <select v-model="filterCourse" @change="handleFilters" class="filter-select">
                <option value="">All Courses</option>
                <option v-for="course in filterOptions.courses" :key="course" :value="course">
                  {{ course }}
                </option>
              </select>
            </div>

            <div class="filter-item">
              <label class="filter-label">Year Level</label>
              <select v-model="filterYearLevel" @change="handleFilters" class="filter-select">
                <option value="">All Year Levels</option>
                <option v-for="year in filterOptions.yearLevels" :key="year" :value="year">
                  {{ year }}
                </option>
              </select>
            </div>

            <div class="filter-item">
              <label class="filter-label">Gender</label>
              <select v-model="filterGender" @change="handleFilters" class="filter-select">
                <option value="">All Genders</option>
                <option v-for="gender in filterOptions.genders" :key="gender" :value="gender">
                  {{ gender }}
                </option>
              </select>
            </div>

            <div class="filter-item">
              <label class="filter-label">City</label>
              <select v-model="filterCity" @change="handleFilters" class="filter-select">
                <option value="">All Cities</option>
                <option v-for="city in filterOptions.cities" :key="city" :value="city">
                  {{ city }}
                </option>
              </select>
            </div>

            <div class="filter-item">
              <label class="filter-label">Ethnicity</label>
              <select v-model="filterEthnicity" @change="handleFilters" class="filter-select">
                <option value="">All</option>
                <option v-for="ethnicity in filterOptions.ethnicities" :key="ethnicity" :value="ethnicity">
                  {{ ethnicity }}
                </option>
              </select>
            </div>

            <div class="filter-item">
              <label class="filter-label">Housing Status</label>
              <select v-model="filterHousingStatus" @change="handleFilters" class="filter-select">
                <option value="">All</option>
                <option v-for="status in filterOptions.housingStatuses" :key="status" :value="status">
                  {{ status }}
                </option>
              </select>
            </div>

            <div class="filter-item filter-checkbox">
              <label class="checkbox-label">
                <input type="checkbox" v-model="filterPwdOnly" @change="handleFilters" class="filter-checkbox-input" />
                <span class="checkbox-text">PWD Only</span>
              </label>
            </div>

            <div class="filter-item filter-actions">
              <button @click="clearFilters" class="clear-filters-btn">
                <i class="fas fa-times-circle"></i> Clear All Filters
              </button>
            </div>

            <div class="filter-item filter-actions">
              <div class="export-dropdown-container">
                <button @click="toggleExportMenu" class="export-btn">
                  <i class="fas fa-download"></i> Export
                  <i :class="showExportMenu ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>
                <div v-if="showExportMenu" class="export-menu">
                  <button @click="handleExport('csv')" class="export-option">
                    <i class="fas fa-file-csv"></i> Export as CSV
                  </button>
                  <button @click="handleExport('excel')" class="export-option">
                    <i class="fas fa-file-excel"></i> Export as Excel
                  </button>
                  <button @click="handleExport('pdf')" class="export-option">
                    <i class="fas fa-file-pdf"></i> Export as PDF
                  </button>
                </div>
              </div>
            </div>
          </div>
        </Transition>
      </div>

      <div class="student-list">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Marital Status</th>
                <th>Religion</th>
                <th>Family Income</th>
                <th>Study Device</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in students.data" :key="student.id" 
                  :class="{ 'highlight-new': student.id === newStudentId }">
                <td>{{ student.student_id }}</td>
                <td>{{ student.first_name }} {{ student.middle_name }} {{ student.last_name }}</td>
                <td>{{ student.course }}</td>
                <td>{{ student.year_level }}</td>
                <td>{{ student.address }}, {{ student.barangay }}, {{ student.city }}, {{ student.province }}</td>
                <td>{{ student.gender }}</td>
                <td>{{ student.marital_status }}</td>
                <td>{{ student.religion }}</td>
                <td>{{ student.family_income_bracket }}</td>
                <td>{{ student.study_device }}</td>
                <td>
                  <div class="action-buttons">
                    <Link :href="`/student/${student.id}/edit`" class="btn-edit">
                      <i class="fas fa-edit"></i> Edit
                    </Link>
                    <button @click="confirmDelete(student)" class="btn-delete">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="students.data.length === 0">
                <td colspan="11" class="text-center">No students found</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="pagination" v-if="students.data.length > 0">
          <template v-for="link in students.links">
            <Link
              v-if="link.url"
              :href="link.url"
              v-html="link.label"
              :class="{'active': link.active}"
              class="page-link"
            />
            <span
              v-else
              v-html="link.label"
              class="page-link disabled"
            />
          </template>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="modal-overlay">
          <div class="modal-content">
            <h3>Confirm Delete</h3>
            <p>Are you sure you want to delete this student?</p>
            <div class="modal-buttons">
              <button @click="deleteStudent" class="delete-confirm-btn">Yes, Delete</button>
              <button @click="showDeleteModal = false" class="cancel-btn">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted, computed } from 'vue';
import debounce from 'lodash/debounce';

const isSidebarOpen = ref(true);
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const page = usePage();

const props = defineProps({
  students: {
    type: Object,
    required: true,
    default: () => ({
      data: [],
      links: []
    })
  },
  filters: {
    type: Object,
    required: true,
    default: () => ({
      search: '',
      course: '',
      year_level: '',
      gender: '',
      city: '',
      ethnicity: '',
      housing_status: '',
      pwd_only: false
    })
  },
  filterOptions: {
    type: Object,
    required: true,
    default: () => ({
      courses: [],
      yearLevels: [],
      genders: [],
      cities: [],
      ethnicities: [],
      housingStatuses: []
    })
  },
  newStudentId: {
    type: Number,
    default: null
  },
});

// Initialize reactive refs
const search = ref(props.filters?.search || '');
const filterCourse = ref(props.filters?.course || '');
const filterYearLevel = ref(props.filters?.year_level || '');
const filterGender = ref(props.filters?.gender || '');
const filterCity = ref(props.filters?.city || '');
const filterEthnicity = ref(props.filters?.ethnicity || '');
const filterHousingStatus = ref(props.filters?.housing_status || '');
const filterPwdOnly = ref(props.filters?.pwd_only || false);
const showFilters = ref(false);
const showExportMenu = ref(false);
const showDeleteModal = ref(false);
const studentToDelete = ref(null);

// Flash message handling
const flashMessageContent = ref(null);
const flashMessageType = ref('success');
const displayFlashMessage = ref(false);
let flashMessageTimer = null;

const showSuccessToast = (message) => {
  flashMessageContent.value = message;
  flashMessageType.value = 'success';
  displayFlashMessage.value = true;
  if (flashMessageTimer) clearTimeout(flashMessageTimer);
  flashMessageTimer = setTimeout(() => dismissFlashMessage(), 5000);
  // Clear the message from page.props.flash if it was the source
  if (page.props.flash?.message === message) {
      page.props.flash.message = null;
  }
};

const showErrorToast = (message) => {
  flashMessageContent.value = message;
  flashMessageType.value = 'error'; // Assuming you have a red style for error
  displayFlashMessage.value = true;
  if (flashMessageTimer) clearTimeout(flashMessageTimer);
  flashMessageTimer = setTimeout(() => dismissFlashMessage(), 7000); // Longer for errors
};

const handleFlashMessage = () => {
  if (page.props.flash?.message) {
    // Use the showSuccessToast to ensure consistent display and clearing logic
    showSuccessToast(page.props.flash.message);
  } else {
    // if (!displayFlashMessage.value) { // Only dismiss if not already showing a manual one
       dismissFlashMessage();
    // }
  }
};

const dismissFlashMessage = () => {
  displayFlashMessage.value = false;
  // flashMessageContent.value = null; // Keep content for fade-out if any animation
  if (flashMessageTimer) {
    clearTimeout(flashMessageTimer);
  }
};

watch(() => page.props.flash,
  (newFlash, oldFlash) => {
    if (newFlash?.message) { // Only trigger if there's an actual new message
        handleFlashMessage();
    }
  },
  { deep: true, immediate: true }
);

const handleFilters = debounce(() => {
  const params = {
    search: search.value,
    course: filterCourse.value,
    year_level: filterYearLevel.value,
    gender: filterGender.value,
    city: filterCity.value,
    ethnicity: filterEthnicity.value,
    housing_status: filterHousingStatus.value,
    pwd_only: filterPwdOnly.value ? '1' : ''
  };
  
  // Remove empty filters
  Object.keys(params).forEach(key => {
    if (params[key] === '' || params[key] === null || params[key] === false) {
      delete params[key];
    }
  });
  
  router.get('/student-list', params, {
    preserveState: true,
    replace: true,
    preserveScroll: true
  });
}, 300);

const toggleFilters = () => {
  showFilters.value = !showFilters.value;
};

const clearFilters = () => {
  search.value = '';
  filterCourse.value = '';
  filterYearLevel.value = '';
  filterGender.value = '';
  filterCity.value = '';
  filterEthnicity.value = '';
  filterHousingStatus.value = '';
  filterPwdOnly.value = false;
  handleFilters();
};

const toggleExportMenu = () => {
  showExportMenu.value = !showExportMenu.value;
};

const handleExport = (format) => {
  // Build URL with current filter params and current page
  const params = new URLSearchParams({
    format: format,
    search: search.value,
    course: filterCourse.value,
    year_level: filterYearLevel.value,
    gender: filterGender.value,
    city: filterCity.value,
    ethnicity: filterEthnicity.value,
    housing_status: filterHousingStatus.value,
    pwd_only: filterPwdOnly.value ? '1' : '',
    page: props.students.current_page || 1
  });
  
  // Remove empty params
  for (let [key, value] of [...params.entries()]) {
    if (!value) params.delete(key);
  }
  
  // Open download URL
  window.location.href = `/student-list/export?${params.toString()}`;
  showExportMenu.value = false;
};

const activeFiltersCount = computed(() => {
  let count = 0;
  if (search.value) count++;
  if (filterCourse.value) count++;
  if (filterYearLevel.value) count++;
  if (filterGender.value) count++;
  if (filterCity.value) count++;
  if (filterEthnicity.value) count++;
  if (filterHousingStatus.value) count++;
  if (filterPwdOnly.value) count++;
  return count;
});

const confirmDelete = (student) => {
  studentToDelete.value = student;
  showDeleteModal.value = true;
};

const deleteStudent = () => {
  if (studentToDelete.value) {
    router.delete(`/student/${studentToDelete.value.id}`, {
      preserveScroll: true, // Keep scroll position
      onSuccess: (pageWithFlash) => { // Inertia passes the updated page object
        showDeleteModal.value = false;
        // Try to use the message from the server if available, otherwise a default
        const message = pageWithFlash.props.flash?.message || 'Student deleted successfully!';
        showSuccessToast(message);
        studentToDelete.value = null;
      },
      onError: (errors) => {
        showDeleteModal.value = false;
        // Example: Join multiple errors or pick the first one
        const errorMessage = Object.values(errors).join(' ') || 'Error deleting student.';
        showErrorToast(errorMessage);
        studentToDelete.value = null;
      }
    });
  }
};

</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Poppins');

* {
  margin: 0;
  padding: 0;
  font-family: 'Poppins';
}
/* body styling should ideally be in a global css file, not scoped here */
/* body {
  width: 100%; 
} */

.container-1 {
  /* padding: 40px 10.5px; */ /* Padding might need adjustment for smaller screens */
  padding: 1rem; /* Example responsive padding */
  /* width: 1920px; */ /* REMOVED FIXED WIDTH */
  width: 100%; /* Make it fluid */
  min-height: 100vh; /* Ensure it takes at least full viewport height */
  display: flex;
  background-color: #F8F9FA;
  /* column-gap: 10px; */
  gap: 1rem; /* Replaced column-gap for modern flexbox */
  position: relative; 
}

.flex {
  display: flex;
}

.inner-container {
  /* width: 1920px; */ /* REMOVED FIXED WIDTH */
  /* This class might not be needed if .container-1 directly manages columns */
}

.first-column {
  /* width: 10%; */ /* Was 10% of fixed 1920px */
  flex-shrink: 0; /* Prevent shrinking */
  width: 280px; /* A fixed width for sidebar, can be responsive with @media */
  /* Alternatively, use percentages or max-width for responsiveness */
  /* e.g., width: 20%; max-width: 280px; */
  /* background-color: white; */ /* Optional: if sidebar has its own bg */
  /* box-shadow: 0 0 10px rgba(0,0,0,0.1); */ /* Optional: sidebar shadow */
  padding: 1rem; /* Added padding */
}

.second-column {
  /* width: 90%; */ /* Was 90% of fixed 1920px */
  flex-grow: 1; /* Allow this column to take remaining space */
  padding: 1rem; /* Added padding */
  overflow-x: auto; /* Allow horizontal scrolling for table if needed on small screens */
}

/* Responsive adjustments for columns if needed */
@media (max-width: 768px) { /* Example breakpoint for tablets and below */
  .container-1 {
    flex-direction: column;
    padding: 0.5rem;
    gap: 0.5rem;
  }
  .first-column {
    width: 100%; 
    /* position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; for an overlay effect on mobile */
    margin-bottom: 1rem; 
  }
  .second-column {
    width: 100%;
  }
  .content-shifted {
    /* No specific shift needed if sidebar stacks above in mobile view */
  }
  .content-full {
    width: 100%;
  }
  .page-info {
    flex-direction: column;
    align-items: flex-start; /* Align items to start on small screens */
  }
  .admin-setting {
    width: 100%;
    margin-top: 1rem;
  }
  .search-bar {
    width: 100%;
    margin-right: 0; /* Remove right margin */
    margin-bottom: 0.5rem; /* Add some space below search */
  }
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
.fas.fa-bar-chart {
  font-size: 15px;
  color: #ffffff;
  background-color: #235F23;
  border-radius: 12px;
  padding: 7.5px;
  margin-right: 11.5px;
}
.fas.fa-home, .fas.fa-plus {
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
  align-items: center;
}
.overview-location {
  padding: 28px 32px;
  box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
  border-radius: 12px;
}
.marg-20 {
  margin-top: 20px;
}
.loc-1 {
  font-size: 10px;
  font-weight: bold;
  color: #A0AEC0;
}
.loc-3 {
  font-size: 14px;
  font-weight: bold;
  color: #2D3748;
}
.loc-4 {
  font-size: 14px;
  font-weight: bold;
  color: #4FD1C5;
}
.loc-5 {
  font-size: 14px;
  font-weight: 400;
}
.map-marker-icon {
  color: #66D494;
  padding-right: 15px;
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
}
.student-info-name {
  align-items: center;
}
.admin-user-icon-2 {
  background-color: #235F23;
  padding: 8.5px;
  border-radius: 12px;
  font-size: 24px;
  color: #ffffff;
  margin-right: 14.5px;
}
.cleared {
  line-height: 19.5px;
  padding: 3px 10px;
  background-color: #48BB78;
  display: inline;
  border-radius: 8px;
  color: #ffffff;
}
.not-cleared {
  line-height: 19.5px;
  padding: 3px 10px;
  background-color: #CBD5E0;
  display: inline;
  border-radius: 8px;
  color: #ffffff;
}
.loc-6 {
  font-size: 12px;
  font-weight: 700;
  color: #718096;
}
.cog-icon {
  font-size: 15px;
  cursor: pointer;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  border-radius: 15px;
  padding: 30px;
  width: 400px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.modal-content h3 {
  margin: 0 0 15px 0;
  font-size: 20px;
  color: #2D3748;
}

.modal-content p {
  margin-bottom: 20px;
  color: #4A5568;
}

.modal-buttons {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.delete-confirm-btn,
.cancel-btn {
  padding: 8px 20px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.2s ease;
}

.delete-confirm-btn {
  background-color: #E53E3E;
  color: white;
}

.delete-confirm-btn:hover {
  background-color: #C53030;
}

.cancel-btn {
  background-color: #EDF2F7;
  color: #2D3748;
}

.cancel-btn:hover {
  background-color: #E2E8F0;
}

.text-center {
  text-align: center;
}

.py-4 {
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.highlight-new {
  background-color: #e6ffe6;
  animation: highlight 2s ease-out;
}

@keyframes highlight {
  0% { background-color: #90EE90; }
  100% { background-color: #e6ffe6; }
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.table th,
.table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}

.table th {
  background-color: #f9fafb;
  font-weight: 600;
}

.action-buttons {
  display: flex;
  gap: 10px;
}

.btn-edit,
.btn-delete {
  padding: 6px 12px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 14px;
}

.btn-edit {
  background-color: #3b82f6;
  color: white;
  text-decoration: none;
}

.btn-delete {
  background-color: #ef4444;
  color: white;
}

.pagination {
  display: flex;
  justify-content: center;
  gap: 5px;
  margin-top: 20px;
}

.page-link {
  padding: 8px 12px;
  border: 1px solid #dee2e6;
  color: #235F23;
  text-decoration: none;
  border-radius: 4px;
  cursor: pointer;
}

.page-link.active {
  background-color: #235F23;
  color: white;
  border-color: #235F23;
}

.page-link.disabled {
  color: #6c757d;
  pointer-events: none;
  background-color: #fff;
  border-color: #dee2e6;
  cursor: not-allowed;
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
  transform: translateX(-280px); /* Slide out to the left */
  opacity: 0;
}

/* Adjust second-column based on sidebar visibility for desktop */
.content-full {
  width: 100%;
  margin-left: 0;
}
.content-shifted {
  /* margin-left: 280px; */ /* Width of the sidebar - flexbox should handle this */
  /* width: calc(100% - 280px); */
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

/* Filter Section Styles */
.filters-section {
  background-color: white;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filters-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.filters-title {
  font-size: 18px;
  font-weight: 600;
  color: #2D3748;
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0;
}

.filters-title .fas.fa-filter {
  color: #235F23;
  background-color: transparent;
  padding: 0;
  margin: 0;
  border-radius: 0;
  font-size: 18px;
}

.active-filters-badge {
  background-color: #235F23;
  color: white;
  border-radius: 50%;
  padding: 2px 8px;
  font-size: 12px;
  font-weight: 700;
  min-width: 24px;
  text-align: center;
  display: inline-block;
}

.toggle-filters-btn {
  background-color: #EDF2F7;
  color: #2D3748;
  border: none;
  padding: 8px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.toggle-filters-btn:hover {
  background-color: #E2E8F0;
}

.toggle-filters-btn .fas {
  font-size: 12px;
  background-color: transparent;
  color: #2D3748;
  padding: 0;
  margin: 0;
  border-radius: 0;
}

.filters-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 15px;
  margin-top: 15px;
}

@media (max-width: 768px) {
  .filters-grid {
    grid-template-columns: 1fr;
  }
}

.filter-item {
  display: flex;
  flex-direction: column;
}

.filter-label {
  font-size: 12px;
  font-weight: 600;
  color: #4A5568;
  margin-bottom: 5px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-select {
  padding: 8px 12px;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  font-size: 14px;
  color: #2D3748;
  background-color: white;
  cursor: pointer;
  transition: all 0.2s ease;
}

.filter-select:hover {
  border-color: #CBD5E0;
}

.filter-select:focus {
  outline: none;
  border-color: #235F23;
  box-shadow: 0 0 0 3px rgba(35, 95, 35, 0.1);
}

.filter-checkbox {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-top: 20px;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  font-size: 14px;
  color: #2D3748;
  font-weight: 500;
}

.filter-checkbox-input {
  width: 18px;
  height: 18px;
  cursor: pointer;
  accent-color: #235F23;
}

.checkbox-text {
  user-select: none;
}

.filter-actions {
  display: flex;
  align-items: flex-end;
  justify-content: center;
}

.clear-filters-btn {
  background-color: #E53E3E;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  width: 100%;
  justify-content: center;
}

.clear-filters-btn:hover {
  background-color: #C53030;
}

.clear-filters-btn .fas {
  background-color: transparent;
  color: white;
  padding: 0;
  margin: 0;
  border-radius: 0;
  font-size: 14px;
}

/* Filter transition animations */
.filter-slide-enter-active,
.filter-slide-leave-active {
  transition: all 0.3s ease;
  overflow: hidden;
}

.filter-slide-enter-from {
  opacity: 0;
  max-height: 0;
  transform: translateY(-10px);
}

.filter-slide-enter-to {
  opacity: 1;
  max-height: 500px;
  transform: translateY(0);
}

.filter-slide-leave-from {
  opacity: 1;
  max-height: 500px;
  transform: translateY(0);
}

.filter-slide-leave-to {
  opacity: 0;
  max-height: 0;
  transform: translateY(-10px);
}

/* Export Button and Dropdown Styles */
.export-dropdown-container {
  position: relative;
  width: 100%;
  margin-top: 10px;
}

.export-btn {
  background-color: #235F23;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
  width: 100%;
}

.export-btn:hover {
  background-color: #1a4a1a;
}

.export-btn .fas {
  background-color: transparent;
  color: white;
  padding: 0;
  margin: 0;
  border-radius: 0;
  font-size: 14px;
}

.export-menu {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: white;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  margin-top: 4px;
  z-index: 10;
  overflow: hidden;
}

.export-option {
  width: 100%;
  padding: 10px 16px;
  border: none;
  background: white;
  text-align: left;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #2D3748;
  transition: all 0.2s ease;
}

.export-option:first-child {
  border-radius: 8px 8px 0 0;
}

.export-option:last-child {
  border-radius: 0 0 8px 8px;
}

.export-option:hover {
  background-color: #F7FAFC;
}

.export-option .fas {
  color: #235F23;
  background-color: transparent;
  padding: 0;
  margin: 0;
  border-radius: 0;
  font-size: 14px;
}
</style>