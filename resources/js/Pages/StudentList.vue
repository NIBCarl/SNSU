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
            <Link href="/add-new" class="dashboard"><i class="fas fa-plus"></i>Add new</Link>
          </div>
        </div>
        <AddNewCTA />
      </div>
    </Transition>
    <div class="inner-container second-column" :class="{ 'content-shifted': isSidebarOpen, 'content-full': !isSidebarOpen }">
      <!-- Flash Message / Toast Notification -->
      <div v-if="displayFlashMessage && flashMessageContent" 
           class="flash-overlay">
        <div class="flash-modal" :class="flashMessageType === 'success' ? 'flash-success' : 'flash-error'">
          <div class="flash-icon-container">
            <div class="flash-icon">
              <i :class="flashMessageType === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'"></i>
            </div>
          </div>
          <div class="flash-content">
            <h3 class="flash-title">{{ flashMessageType === 'success' ? 'Success!' : 'Error!' }}</h3>
            <p class="flash-message">{{ flashMessageContent }}</p>
          </div>
          <button @click="dismissFlashMessage" class="flash-close">&times;</button>
        </div>
      </div>

      <div class="page-info flex items-center">
        <button @click="toggleSidebar" class="hamburger-button">
          <svg class="hamburger-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Student List</h1>
        <div class="admin-setting flex">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input v-model="search" class="main-input" type="text" placeholder="Search students..." @input="handleFilters" />
          </div>
          <ul class="admin-icons flex">
            <Link href="/profile" class="admin">
              <i class="fas fa-user admin-user-icon"></i>admin
            </Link>
            <div class="cog-icon" @click="toggleModal">⚙️</div>
            <div class="modal" v-if="showModal">
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
                <th>Ethnicity</th>
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
                <td>{{ student.ethnicity || 'N/A' }}</td>
                <td>{{ student.family_income || 'N/A' }}</td>
                <td>{{ student.study_device }}</td>
                <td>
                  <div class="action-buttons">
                    <button @click="openEditModal(student)" class="btn-edit">
                      <i class="fas fa-edit"></i> Edit
                    </button>
                    <button @click="confirmDelete(student)" class="btn-delete">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="students.data.length === 0">
                <td colspan="12" class="text-center">No students found</td>
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

        <!-- Edit Student Modal -->
        <div v-if="showEditModal" class="modal-overlay" @click.self="closeEditModal">
          <div class="modal-content-large">
            <div class="modal-header">
              <h3>Edit Student Information</h3>
              <button @click="closeEditModal" class="close-button">&times;</button>
            </div>
            <form @submit.prevent="updateStudent" class="edit-form">
              <!-- Personal Information Section -->
              <h4 class="section-title-modal">Personal Information</h4>
              <div class="form-row-3">
                <div class="form-group-modal">
                  <label>First Name</label>
                  <input v-model="editForm.first_name" type="text" required />
                  <div v-if="editErrors.first_name" class="error">{{ editErrors.first_name }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Middle Name</label>
                  <input v-model="editForm.middle_name" type="text" />
                  <div v-if="editErrors.middle_name" class="error">{{ editErrors.middle_name }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Last Name</label>
                  <input v-model="editForm.last_name" type="text" required />
                  <div v-if="editErrors.last_name" class="error">{{ editErrors.last_name }}</div>
                </div>
              </div>

              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Student ID</label>
                  <input 
                    v-model="editForm.student_id" 
                    type="text" 
                    pattern="\d{4}-\d{5}"
                    placeholder="2023-01292"
                    title="Format: YYYY-##### (e.g., 2023-01292)"
                    required 
                  />
                  <p class="input-helper-text">Format: YYYY-##### (e.g., 2023-01292)</p>
                  <div v-if="editErrors.student_id" class="error">{{ editErrors.student_id }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Birth Date</label>
                  <input v-model="editForm.birth_date" type="date" required />
                  <div v-if="editErrors.birth_date" class="error">{{ editErrors.birth_date }}</div>
                </div>
              </div>

              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Gender</label>
                  <select v-model="editForm.gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                  <div v-if="editErrors.gender" class="error">{{ editErrors.gender }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Marital Status</label>
                  <select v-model="editForm.marital_status" required>
                    <option value="">Select Marital Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                  </select>
                  <div v-if="editErrors.marital_status" class="error">{{ editErrors.marital_status }}</div>
                </div>
              </div>

              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Religion</label>
                  <input v-model="editForm.religion" type="text" required />
                  <div v-if="editErrors.religion" class="error">{{ editErrors.religion }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Cellphone Number</label>
                  <input v-model="editForm.cellphone_number" type="tel" />
                  <div v-if="editErrors.cellphone_number" class="error">{{ editErrors.cellphone_number }}</div>
                </div>
              </div>

              <!-- Academic Information Section -->
              <h4 class="section-title-modal">Academic Information</h4>
              <div class="form-group-modal">
                <label>Course</label>
                <input v-model="editForm.course" type="text" required />
                <div v-if="editErrors.course" class="error">{{ editErrors.course }}</div>
              </div>
              <div class="form-group-modal">
                <label>Year Level</label>
                <select v-model="editForm.year_level" required>
                  <option value="">Select Year Level</option>
                  <option value="1st Year">1st Year</option>
                  <option value="2nd Year">2nd Year</option>
                  <option value="3rd Year">3rd Year</option>
                  <option value="4th Year">4th Year</option>
                  <option value="Others">Others</option>
                </select>
                <div v-if="editErrors.year_level" class="error">{{ editErrors.year_level }}</div>
              </div>

              <!-- Address Section -->
              <h4 class="section-title-modal">Address Information</h4>
              <div class="form-group-modal">
                <label>Address (House No./Street)</label>
                <input v-model="editForm.address" type="text" required />
                <div v-if="editErrors.address" class="error">{{ editErrors.address }}</div>
              </div>
              <div class="form-row-3">
                <div class="form-group-modal">
                  <label>Barangay</label>
                  <input v-model="editForm.barangay" type="text" required />
                  <div v-if="editErrors.barangay" class="error">{{ editErrors.barangay }}</div>
                </div>
                <div class="form-group-modal">
                  <label>City/Municipality</label>
                  <input v-model="editForm.city" type="text" required />
                  <div v-if="editErrors.city" class="error">{{ editErrors.city }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Province</label>
                  <input v-model="editForm.province" type="text" required />
                  <div v-if="editErrors.province" class="error">{{ editErrors.province }}</div>
                </div>
              </div>
              <div class="form-group-modal">
                <label>Postal Code</label>
                <input v-model="editForm.postal_code" type="text" required />
                <div v-if="editErrors.postal_code" class="error">{{ editErrors.postal_code }}</div>
              </div>

              <!-- Parent Information Section -->
              <h4 class="section-title-modal">Parent Information</h4>
              <div class="form-row-3">
                <div class="form-group-modal">
                  <label>Father's Name</label>
                  <input v-model="editForm.father_name" type="text" required />
                  <div v-if="editErrors.father_name" class="error">{{ editErrors.father_name }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Mother's Name</label>
                  <input v-model="editForm.mother_name" type="text" required />
                  <div v-if="editErrors.mother_name" class="error">{{ editErrors.mother_name }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Family Income (Monthly Gross)</label>
                  <select v-model="editForm.family_income" required>
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
                  <div v-if="editErrors.family_income" class="error">{{ editErrors.family_income }}</div>
                </div>
              </div>

              <!-- Socio-Economic Information Section -->
              <h4 class="section-title-modal">Socio-Economic Information</h4>
              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Primary Study Device</label>
                  <select v-model="editForm.study_device">
                    <option value="">Select Study Device</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Desktop">Desktop</option>
                    <option value="Mobile Phone">Mobile Phone</option>
                  </select>
                  <div v-if="editErrors.study_device" class="error">{{ editErrors.study_device }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Household Size</label>
                  <input v-model="editForm.household_size" type="number" min="1" required />
                  <div v-if="editErrors.household_size" class="error">{{ editErrors.household_size }}</div>
                </div>
              </div>

              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Housing Status</label>
                  <select v-model="editForm.housing_status" required>
                    <option value="">Select Housing Status</option>
                    <option value="Owned">Owned</option>
                    <option value="Renting">Renting</option>
                    <option value="Living with Relatives">Living with Relatives</option>
                    <option value="Other">Other</option>
                  </select>
                  <div v-if="editErrors.housing_status" class="error">{{ editErrors.housing_status }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Monthly Boarding/Rental (PHP, if applicable)</label>
                  <input v-model="editForm.monthly_rental" type="number" min="0" step="0.01" />
                  <div v-if="editErrors.monthly_rental" class="error">{{ editErrors.monthly_rental }}</div>
                </div>
              </div>

              <!-- Status Checkboxes Section -->
              <div class="checkbox-section-modal">
                <!-- Solo Parent Row -->
                <div class="checkbox-row-modal">
                  <div class="checkbox-wrapper-modal">
                    <input type="checkbox" v-model="editForm.is_solo_parent" class="checkbox-input" id="edit_soloParent">
                    <label class="checkbox-text" for="edit_soloParent">Are you a solo parent?</label>
                  </div>
                  <div v-if="editForm.is_solo_parent" class="conditional-input-modal">
                    <label for="edit_solo_parent_id">Solo Parent ID No.</label>
                    <input v-model="editForm.solo_parent_id" type="text" placeholder="Solo Parent ID No." />
                  </div>
                </div>
                
                <!-- Part-Time Job Row -->
                <div class="checkbox-row-modal">
                  <div class="checkbox-wrapper-modal">
                    <input type="checkbox" v-model="editForm.has_part_time_job" class="checkbox-input" id="edit_partTimeJob">
                    <label class="checkbox-text" for="edit_partTimeJob">Do you have a part-time job?</label>
                  </div>
                </div>
                
                <!-- PWD Row -->
                <div class="checkbox-row-modal">
                  <div class="checkbox-wrapper-modal">
                    <input type="checkbox" v-model="editForm.pwd" class="checkbox-input" id="edit_pwd">
                    <label class="checkbox-text" for="edit_pwd">Are you a Person with Disability (PWD)?</label>
                  </div>
                  <div v-if="editForm.pwd" class="conditional-input-modal">
                    <label for="edit_pwd_id">PWD ID Number</label>
                    <input v-model="editForm.pwd_id" type="text" placeholder="PWD ID No." />
                  </div>
                </div>
              </div>

              <div class="form-row-2">
                <div class="form-group-modal">
                  <label>Daily Fare</label>
                  <select v-model="editForm.daily_fare">
                    <option value="">Select Daily Fare</option>
                    <option value="Php 20.00 - Php 50.00">Php 20.00 - Php 50.00</option>
                    <option value="Php. 51.00 - Php 100.00">Php. 51.00 - Php 100.00</option>
                    <option value="Php 101.00 - Php 200.00">Php 101.00 - Php 200.00</option>
                    <option value="Php 201.00 - Php 300.00">Php 201.00 - Php 300.00</option>
                    <option value="N/A">N/A</option>
                  </select>
                  <div v-if="editErrors.daily_fare" class="error">{{ editErrors.daily_fare }}</div>
                </div>
              </div>

              <!-- Transportation & Ethnicity Section -->
              <h4 class="section-title-modal">Transportation & Ethnicity</h4>
              <div class="form-row-3">
                <div class="form-group-modal">
                  <label>Mode of Transportation to School</label>
                  <select v-model="editForm.transportation_mode" required>
                    <option value="">Select Transportation</option>
                    <option value="Car">Car</option>
                    <option value="Jeep/Multicab">Jeep/Multicab</option>
                    <option value="Motorcycle">Motorcycle</option>
                    <option value="Tricycle">Tricycle</option>
                    <option value="None">None</option>
                  </select>
                  <div v-if="editErrors.transportation_mode" class="error">{{ editErrors.transportation_mode }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Travel Time to School (minutes)</label>
                  <input v-model="editForm.travel_time_minutes" type="number" min="0" required />
                  <div v-if="editErrors.travel_time_minutes" class="error">{{ editErrors.travel_time_minutes }}</div>
                </div>
                <div class="form-group-modal">
                  <label>Ethnicity</label>
                  <select v-model="editForm.ethnicity" required>
                    <option value="">Select Ethnicity</option>
                    <option value="Indigenous">Indigenous</option>
                    <option value="Non-Indigenous">Non-Indigenous</option>
                  </select>
                  <div v-if="editErrors.ethnicity" class="error">{{ editErrors.ethnicity }}</div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" @click="closeEditModal" class="cancel-btn">Cancel</button>
                <button type="submit" class="update-btn" :disabled="editProcessing">
                  {{ editProcessing ? 'Updating...' : 'Update Student' }}
                </button>
              </div>
            </form>
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
import AddNewCTA from '@/Components/AddNewCTA.vue';

const isSidebarOpen = ref(true);
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const showModal = ref(false);
const toggleModal = () => {
  showModal.value = !showModal.value;
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
const showEditModal = ref(false);
const studentToEdit = ref(null);
const editProcessing = ref(false);
const editErrors = ref({});

// Flash message handling
const flashMessageContent = ref(null);
const flashMessageType = ref('success');
const displayFlashMessage = ref(false);
let flashMessageTimer = null;

// Edit form data
const editForm = ref({
  first_name: '',
  middle_name: '',
  last_name: '',
  student_id: '',
  course: '',
  year_level: '',
  gender: '',
  birth_date: '',
  marital_status: 'Single',
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
  family_income: ''
});

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

const openEditModal = (student) => {
  studentToEdit.value = student;
  editForm.value = {
    first_name: student.first_name || '',
    middle_name: student.middle_name || '',
    last_name: student.last_name || '',
    student_id: student.student_id || '',
    course: student.course || '',
    year_level: student.year_level || '',
    gender: student.gender || '',
    birth_date: student.birth_date || '',
    marital_status: student.marital_status || 'Single',
    religion: student.religion || '',
    cellphone_number: student.cellphone_number || '',
    address: student.address || '',
    barangay: student.barangay || '',
    city: student.city || '',
    province: student.province || '',
    postal_code: student.postal_code || '',
    study_device: student.study_device || '',
    is_solo_parent: student.is_solo_parent || false,
    solo_parent_id: student.solo_parent_id || '',
    has_part_time_job: student.has_part_time_job || false,
    daily_fare: student.daily_fare || '',
    monthly_rental: student.monthly_rental || null,
    father_name: student.father_name || '',
    mother_name: student.mother_name || '',
    household_size: student.household_size || null,
    transportation_mode: student.transportation_mode || '',
    travel_time_minutes: student.travel_time_minutes || null,
    ethnicity: student.ethnicity || '',
    pwd: student.pwd || false,
    pwd_id: student.pwd_id || '',
    housing_status: student.housing_status || '',
    family_income: student.family_income || ''
  };
  editErrors.value = {};
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
  studentToEdit.value = null;
  editErrors.value = {};
};

const updateStudent = () => {
  if (!studentToEdit.value) return;
  
  editProcessing.value = true;
  editErrors.value = {};
  
  router.put(`/student/${studentToEdit.value.id}`, editForm.value, {
    preserveScroll: true,
    onSuccess: () => {
      editProcessing.value = false;
      showEditModal.value = false;
      showSuccessToast('Student updated successfully!');
      studentToEdit.value = null;
    },
    onError: (errors) => {
      editProcessing.value = false;
      editErrors.value = errors;
      showErrorToast('Please check the form for errors.');
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
  background-color: white; /* Added for consistency with AddNew page */
  border-radius: 15px; /* Added for card-like appearance matching AddNew */
  padding: 1rem; /* Added padding */
}

.second-column {
  /* width: 90%; */ /* Was 90% of fixed 1920px */
  flex-grow: 1; /* Allow this column to take remaining space */
  padding: 1rem; /* Added padding */
  overflow-x: auto; /* Allow horizontal scrolling for table if needed on small screens */
  background-color: white; /* Added for consistency with AddNew page */
  border-radius: 15px; /* Added for card-like appearance matching AddNew */
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
/* CTA button styles moved to AddNewCTA.vue component */
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

/* ===== SETTINGS MODAL (Admin Profile) ===== */
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

.modal .modal-content {
  background-color: white;
  border-radius: 15px;
  padding: 30px;
  width: 300px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: relative;
}

.modal .close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
  color: #4A5568;
}

.modal .close:hover {
  color: #2D3748;
}

.modal .profile-picture {
  margin-bottom: 15px;
}

.modal .profile-picture .avatar {
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

.modal .profile-picture .avatar i {
  font-size: 40px;
  color: #ffffff;
}

.modal .modal-content h2 {
  font-size: 18px;
  margin-bottom: 10px;
  color: #2D3748;
  font-weight: 600;
}

.modal .modal-content p {
  font-size: 14px;
  color: #4A5568;
  margin-bottom: 20px;
  font-weight: 500;
}

.modal .sign-out {
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

.modal .sign-out:hover {
  background-color: #fff5f5;
  text-decoration: none;
}

/* ===== DELETE CONFIRMATION MODAL ===== */
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

/* ===== ENHANCED TABLE STYLING WITH DEPTH ===== */
.student-list {
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  border-radius: 15px;
  padding: 24px;
  margin-bottom: 20px;
  /* Layered shadow for depth - light glow on top, dark shadow at bottom */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
}

.table-responsive {
  overflow-x: auto;
  border-radius: 12px;
  /* Subtle inset shadow to make table appear slightly recessed */
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) inset;
}

.table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin-top: 0;
  background-color: #ffffff;
}

.table th,
.table td {
  padding: 16px 12px;
  text-align: left;
  border-bottom: 1px solid #f0f0f0;
}

.table thead tr {
  position: relative;
}

.table th {
  background: linear-gradient(to bottom, #ffffff 0%, #f7f9fa 100%);
  font-weight: 700;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #4A5568;
  /* Light shadow on top, dark at bottom for elevated appearance */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.05);
  border-bottom: 2px solid #e2e8f0;
  position: relative;
}

.table th:first-child {
  border-top-left-radius: 12px;
}

.table th:last-child {
  border-top-right-radius: 12px;
}

.table tbody tr {
  background-color: #ffffff;
  transition: all 0.2s ease;
}

.table tbody tr:hover {
  background: linear-gradient(to right, #fafbfc 0%, #ffffff 100%);
  /* Slight elevation on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.5) inset,
    0 2px 8px rgba(0, 0, 0, 0.06);
  transform: translateX(2px);
}

.table tbody tr:last-child td:first-child {
  border-bottom-left-radius: 12px;
}

.table tbody tr:last-child td:last-child {
  border-bottom-right-radius: 12px;
}

.action-buttons {
  display: flex;
  gap: 10px;
}

/* ===== ENHANCED BUTTON STYLING WITH PROMINENCE ===== */
.btn-edit,
.btn-delete {
  padding: 8px 16px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s ease;
  position: relative;
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 2px 4px rgba(0, 0, 0, 0.1),
    0 1px 2px rgba(0, 0, 0, 0.08);
}

.btn-edit {
  background: linear-gradient(to bottom, #4c94ff 0%, #3b82f6 100%);
  color: white;
  text-decoration: none;
}

.btn-edit:hover {
  background: linear-gradient(to bottom, #5da3ff 0%, #4c94ff 100%);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.3) inset,
    0 4px 8px rgba(59, 130, 246, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.btn-delete {
  background: linear-gradient(to bottom, #f56565 0%, #ef4444 100%);
  color: white;
}

.btn-delete:hover {
  background: linear-gradient(to bottom, #fc8181 0%, #f56565 100%);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.3) inset,
    0 4px 8px rgba(239, 68, 68, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

/* ===== ENHANCED PAGINATION WITH DEPTH ===== */
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-top: 24px;
}

.page-link {
  padding: 10px 14px;
  border: 1px solid #e2e8f0;
  color: #235F23;
  text-decoration: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.2s ease;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.06);
}

.page-link:hover:not(.disabled) {
  background: linear-gradient(to bottom, #f8f9fa 0%, #f0f0f0 100%);
  border-color: #cbd5e0;
  transform: translateY(-1px);
  /* Slightly bigger shadow on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 4px 6px rgba(0, 0, 0, 0.08);
}

.page-link.active {
  background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
  color: white;
  border-color: #235F23;
  /* Inset shadow to make it appear pressed */
  box-shadow: 
    0 2px 4px rgba(0, 0, 0, 0.2) inset,
    0 1px 2px rgba(0, 0, 0, 0.1);
}

.page-link.disabled {
  color: #a0aec0;
  pointer-events: none;
  background: linear-gradient(to bottom, #fafafa 0%, #f0f0f0 100%);
  border-color: #e2e8f0;
  cursor: not-allowed;
  box-shadow: none;
}

/* ===== IMPROVED SIDEBAR TRANSITION ===== */
.slide-fade-enter-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth ease-in-out */
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 1, 1); /* Slightly faster leave */
}

.slide-fade-enter-from {
  transform: translateX(-300px); /* Slide in from left */
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateX(-300px); /* Slide out to left */
  opacity: 0;
}

/* Adjust second-column based on sidebar visibility for desktop */
.content-full {
  width: 100%;
  margin-left: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth expansion */
}
.content-shifted {
  /* margin-left: 280px; */ /* Width of the sidebar - flexbox should handle this */
  /* width: calc(100% - 280px); */
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

/* ===== ENHANCED FILTER SECTION WITH DEPTH ===== */
.filters-section {
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  border-radius: 15px;
  padding: 24px;
  margin-bottom: 20px;
  /* Layered shadow for depth */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
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
  background: linear-gradient(to bottom, #f7fafc 0%, #EDF2F7 100%);
  color: #2D3748;
  border: 1px solid #e2e8f0;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.06);
}

.toggle-filters-btn:hover {
  background: linear-gradient(to bottom, #edf2f7 0%, #e2e8f0 100%);
  border-color: #cbd5e0;
  /* Slightly bigger shadow on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 3px 6px rgba(0, 0, 0, 0.08);
  transform: translateY(-1px);
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
  padding: 10px 14px;
  border: 1px solid #E2E8F0;
  border-radius: 8px;
  font-size: 14px;
  color: #2D3748;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  cursor: pointer;
  transition: all 0.2s ease;
  /* Small inset shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.04);
}

.filter-select:hover {
  border-color: #CBD5E0;
  background: linear-gradient(to bottom, #fafafa 0%, #f5f5f5 100%);
}

.filter-select:focus {
  outline: none;
  border-color: #235F23;
  background: linear-gradient(to bottom, #ffffff 0%, #f9f9f9 100%);
  /* Glowing effect on focus */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 0 0 3px rgba(35, 95, 35, 0.1),
    0 2px 4px rgba(0, 0, 0, 0.05);
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
  background: linear-gradient(to bottom, #f56565 0%, #E53E3E 100%);
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
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 2px 4px rgba(0, 0, 0, 0.1),
    0 1px 2px rgba(0, 0, 0, 0.08);
}

.clear-filters-btn:hover {
  background: linear-gradient(to bottom, #fc8181 0%, #f56565 100%);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.3) inset,
    0 4px 8px rgba(229, 62, 62, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
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
  background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
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
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 2px 4px rgba(0, 0, 0, 0.1),
    0 1px 2px rgba(0, 0, 0, 0.08);
}

.export-btn:hover {
  background: linear-gradient(to bottom, #3a9a3a 0%, #2d7d2d 100%);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.3) inset,
    0 4px 8px rgba(35, 95, 35, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
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
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  border: 1px solid #E2E8F0;
  border-radius: 10px;
  /* Enhanced shadow for floating effect */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 8px 16px rgba(0, 0, 0, 0.12),
    0 4px 8px rgba(0, 0, 0, 0.08);
  margin-top: 6px;
  z-index: 10;
  overflow: hidden;
}

.export-option {
  width: 100%;
  padding: 12px 16px;
  border: none;
  background: transparent;
  text-align: left;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
  font-weight: 500;
  color: #2D3748;
  transition: all 0.2s ease;
}

.export-option:first-child {
  border-radius: 10px 10px 0 0;
}

.export-option:last-child {
  border-radius: 0 0 10px 10px;
}

.export-option:hover {
  background: linear-gradient(to right, #f0f4f8 0%, #fafbfc 100%);
  color: #235F23;
  /* Light shadow on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.5) inset,
    0 2px 4px rgba(0, 0, 0, 0.04);
  transform: translateX(2px);
}

.export-option .fas {
  color: #235F23;
  background-color: transparent;
  padding: 0;
  margin: 0;
  border-radius: 0;
  font-size: 14px;
}

/* ===== ENHANCED FLASH MESSAGE MODAL ===== */
.flash-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  background: radial-gradient(circle at center, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.4) 100%);
  backdrop-filter: blur(4px);
  animation: fadeIn 0.3s ease-out;
}

.flash-modal {
  background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
  border-radius: 16px;
  padding: 32px;
  max-width: 450px;
  width: 100%;
  text-align: center;
  position: relative;
  animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  /* Multi-layered shadows for maximum depth */
  box-shadow: 
    0 2px 0 rgba(255, 255, 255, 0.9) inset,
    0 30px 60px rgba(0, 0, 0, 0.25),
    0 15px 30px rgba(0, 0, 0, 0.15),
    0 5px 10px rgba(0, 0, 0, 0.1);
}

.flash-icon-container {
  margin-bottom: 20px;
}

.flash-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  /* Icon will have gradient based on success/error */
}

.flash-success .flash-icon {
  background: linear-gradient(135deg, #48bb78 0%, #38a169 50%, #2f855a 100%);
  box-shadow: 
    0 2px 0 rgba(255, 255, 255, 0.3) inset,
    0 10px 25px rgba(56, 161, 105, 0.4),
    0 5px 15px rgba(56, 161, 105, 0.3),
    0 0 0 4px rgba(56, 161, 105, 0.1);
}

.flash-error .flash-icon {
  background: linear-gradient(135deg, #f56565 0%, #e53e3e 50%, #c53030 100%);
  box-shadow: 
    0 2px 0 rgba(255, 255, 255, 0.3) inset,
    0 10px 25px rgba(229, 62, 62, 0.4),
    0 5px 15px rgba(229, 62, 62, 0.3),
    0 0 0 4px rgba(229, 62, 62, 0.1);
}

.flash-icon i {
  font-size: 42px;
  color: #ffffff;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
}

.flash-content {
  margin-bottom: 8px;
}

.flash-title {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 12px;
  color: #2D3748;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
}

.flash-message {
  font-size: 16px;
  color: #4A5568;
  line-height: 1.6;
  font-weight: 500;
}

.flash-close {
  position: absolute;
  top: 12px;
  right: 12px;
  background: linear-gradient(to bottom, #ffffff 0%, #f7f7f7 100%);
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #718096;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.06);
}

.flash-close:hover {
  background: linear-gradient(to bottom, #f7f7f7 0%, #edf2f7 100%);
  color: #e53e3e;
  border-color: #e53e3e;
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 4px 8px rgba(229, 62, 62, 0.2),
    0 0 0 2px rgba(229, 62, 62, 0.1);
  transform: rotate(90deg);
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* ===== ENHANCED EDIT MODAL STYLING ===== */
.modal-content-large {
  background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 50%, #f1f3f5 100%);
  border-radius: 20px;
  width: 90%;
  max-width: 900px;
  max-height: 90vh;
  overflow: hidden;
  position: relative;
  /* Multi-layered shadows for extreme depth */
  box-shadow: 
    0 3px 0 rgba(255, 255, 255, 0.95) inset,
    0 40px 80px rgba(0, 0, 0, 0.3),
    0 20px 40px rgba(0, 0, 0, 0.2),
    0 10px 20px rgba(0, 0, 0, 0.15),
    0 0 0 1px rgba(0, 0, 0, 0.05);
}

.modal-content-large::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #2d7d2d 0%, #38a169 50%, #2d7d2d 100%);
  box-shadow: 0 2px 8px rgba(45, 125, 45, 0.4);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 28px 36px;
  border-bottom: none;
  position: sticky;
  top: 0;
  /* Elevated header with light-to-dark gradient */
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 50%, #f5f7f9 100%);
  z-index: 10;
  border-radius: 20px 20px 0 0;
  /* Layered shadows - light on top, dark on bottom */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 8px 16px rgba(0, 0, 0, 0.08),
    0 4px 8px rgba(0, 0, 0, 0.05),
    0 1px 0 rgba(0, 0, 0, 0.05);
}

.modal-header h3 {
  margin: 0;
  font-size: 26px;
  font-weight: 700;
  color: #1a202c;
  text-transform: uppercase;
  letter-spacing: 1px;
  /* Subtle text shadow for depth */
  text-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8),
    0 2px 4px rgba(0, 0, 0, 0.05);
  background: linear-gradient(135deg, #2d7d2d 0%, #38a169 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.close-button {
  background: linear-gradient(to bottom, #ffffff 0%, #f7fafc 100%);
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-size: 28px;
  cursor: pointer;
  color: #718096;
  transition: all 0.2s ease;
  line-height: 1;
  padding: 0;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  /* Subtle raised effect */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.06);
}

.close-button:hover {
  background: linear-gradient(to bottom, #fff5f5 0%, #fed7d7 100%);
  color: #e53e3e;
  border-color: #e53e3e;
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(229, 62, 62, 0.25),
    0 0 0 3px rgba(229, 62, 62, 0.1);
  transform: rotate(90deg) scale(1.05);
}

.close-button:active {
  transform: rotate(90deg) scale(0.95);
  box-shadow: 
    0 1px 2px rgba(0, 0, 0, 0.15) inset,
    0 1px 2px rgba(0, 0, 0, 0.1);
}

.edit-form {
  padding: 36px;
  max-height: calc(90vh - 160px);
  overflow-y: auto;
  /* Custom scrollbar */
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.edit-form::-webkit-scrollbar {
  width: 8px;
}

.edit-form::-webkit-scrollbar-track {
  background: linear-gradient(to bottom, #f7fafc 0%, #edf2f7 100%);
  border-radius: 10px;
}

.edit-form::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #cbd5e0 0%, #a0aec0 100%);
  border-radius: 10px;
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.5) inset,
    0 2px 4px rgba(0, 0, 0, 0.1);
}

.edit-form::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #a0aec0 0%, #718096 100%);
}

.section-title-modal {
  font-size: 16px;
  font-weight: 700;
  color: #1a202c;
  margin-top: 32px;
  margin-bottom: 20px;
  padding: 12px 16px;
  /* Recessed background for hierarchy */
  background: linear-gradient(to bottom, #edf2f7 0%, #e2e8f0 100%);
  border-radius: 8px;
  text-transform: uppercase;
  letter-spacing: 1px;
  /* Inset shadow to push section title back */
  box-shadow: 
    0 2px 4px rgba(0, 0, 0, 0.08) inset,
    0 1px 0 rgba(255, 255, 255, 0.8);
  position: relative;
}

.section-title-modal::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(to bottom, #2d7d2d 0%, #38a169 100%);
  border-radius: 8px 0 0 8px;
  box-shadow: 2px 0 6px rgba(45, 125, 45, 0.3);
}

.section-title-modal:first-child {
  margin-top: 0;
}

.form-group-modal {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.form-group-modal label {
  margin-bottom: 8px;
  color: #4A5568;
  font-weight: 600;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-group-modal input,
.form-group-modal select {
  padding: 14px 18px;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  color: #2d3748;
  font-weight: 500;
  /* Slightly recessed look - darker at bottom for depth */
  background: linear-gradient(to bottom, #fafbfc 0%, #ffffff 50%, #f9fafb 100%);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  /* Inset shadow on top, outset on bottom for realism */
  box-shadow: 
    0 1px 2px rgba(0, 0, 0, 0.05) inset,
    0 1px 0 rgba(255, 255, 255, 0.9),
    0 2px 4px rgba(0, 0, 0, 0.04);
}

.form-group-modal input:hover,
.form-group-modal select:hover {
  border-color: #cbd5e0;
  /* Lighter gradient on hover = lifted effect */
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 50%, #f5f7f9 100%);
  box-shadow: 
    0 1px 2px rgba(0, 0, 0, 0.04) inset,
    0 1px 0 rgba(255, 255, 255, 1),
    0 4px 8px rgba(0, 0, 0, 0.06);
  transform: translateY(-1px);
}

.form-group-modal input:focus,
.form-group-modal select:focus {
  outline: none;
  border-color: #38a169;
  /* Brightest gradient on focus = most elevated */
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  /* Multiple shadow layers for maximum prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 1) inset,
    0 0 0 4px rgba(56, 161, 105, 0.15),
    0 6px 16px rgba(56, 161, 105, 0.12),
    0 3px 8px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
}

.checkbox-section-modal {
  /* Recessed section - darker colors push back */
  background: linear-gradient(to bottom, #edf2f7 0%, #e2e8f0 50%, #cbd5e0 100%);
  padding: 1.75rem;
  border-radius: 12px;
  margin: 1.5rem 0;
  /* Strong inset shadow to push the section deep */
  box-shadow: 
    0 3px 6px rgba(0, 0, 0, 0.1) inset,
    0 1px 0 rgba(255, 255, 255, 0.6),
    0 2px 4px rgba(0, 0, 0, 0.04);
  border: 1px solid #cbd5e0;
}

.checkbox-row-modal {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
  margin-bottom: 1rem;
  align-items: start;
}

@media (max-width: 768px) {
  .checkbox-row-modal {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}

.checkbox-wrapper-modal {
  display: flex;
  align-items: center;
  padding: 0.875rem 1.25rem;
  /* Elevated card within recessed section */
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 50%, #f7fafc 100%);
  border-radius: 10px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid #e2e8f0;
  /* Light shadows for subtle elevation */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 3px 6px rgba(0, 0, 0, 0.06),
    0 1px 3px rgba(0, 0, 0, 0.04);
}

.checkbox-wrapper-modal:hover {
  /* Lighter gradient = more elevated on hover */
  background: linear-gradient(to bottom, #ffffff 0%, #ffffff 50%, #fafbfc 100%);
  border-color: #cbd5e0;
  /* Bigger shadow for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 1) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 3px 6px rgba(0, 0, 0, 0.06);
  transform: translateY(-2px);
}

.conditional-input-modal {
  display: flex;
  flex-direction: column;
  animation: slideIn 0.3s ease-out;
}

.conditional-input-modal label {
  margin-bottom: 0.5rem;
  font-size: 0.75rem;
  font-weight: 700;
  color: #4a5568;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.conditional-input-modal input {
  padding: 12px 16px;
  border: 1px solid #E2E8F0;
  border-radius: 10px;
  font-size: 14px;
  color: #2D3748;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  transition: all 0.2s ease;
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.04);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 16px;
  padding: 28px 36px;
  border-top: none;
  position: sticky;
  bottom: 0;
  /* Elevated footer */
  background: linear-gradient(to bottom, #f5f7f9 0%, #fafbfc 50%, #ffffff 100%);
  border-radius: 0 0 20px 20px;
  margin-top: 24px;
  /* Shadow on top to separate from form */
  box-shadow: 
    0 -8px 16px rgba(0, 0, 0, 0.08),
    0 -4px 8px rgba(0, 0, 0, 0.04),
    0 1px 0 rgba(255, 255, 255, 0.9);
}

.update-btn {
  /* Prominent green button - lightest shade for importance */
  background: linear-gradient(135deg, #48bb78 0%, #38a169 50%, #2f855a 100%);
  color: white;
  padding: 14px 36px;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  /* Multiple shadow layers for maximum prominence */
  box-shadow: 
    0 2px 0 rgba(255, 255, 255, 0.25) inset,
    0 8px 20px rgba(56, 161, 105, 0.35),
    0 4px 10px rgba(56, 161, 105, 0.25),
    0 2px 5px rgba(0, 0, 0, 0.1);
}

.update-btn:hover:not(:disabled) {
  /* Even lighter on hover for more elevation */
  background: linear-gradient(135deg, #68d391 0%, #48bb78 50%, #38a169 100%);
  /* Bigger shadows = more prominent */
  box-shadow: 
    0 2px 0 rgba(255, 255, 255, 0.3) inset,
    0 12px 28px rgba(56, 161, 105, 0.4),
    0 6px 14px rgba(56, 161, 105, 0.3),
    0 3px 7px rgba(0, 0, 0, 0.15);
  transform: translateY(-3px) scale(1.02);
}

.update-btn:active:not(:disabled) {
  transform: translateY(-1px) scale(0.98);
  /* Inset shadow when pressed */
  box-shadow: 
    0 3px 6px rgba(0, 0, 0, 0.25) inset,
    0 2px 4px rgba(0, 0, 0, 0.15);
}

.update-btn:disabled {
  /* Recessed disabled state */
  background: linear-gradient(to bottom, #cbd5e0 0%, #a0aec0 100%);
  cursor: not-allowed;
  box-shadow: 
    0 2px 4px rgba(0, 0, 0, 0.1) inset,
    0 1px 2px rgba(0, 0, 0, 0.05);
  transform: none;
  opacity: 0.7;
}
</style>