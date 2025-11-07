<template>
  <Head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </Head>
  <div class="container-1">
    <div class="inner-container first-column">
      <div class="logo-sec">
        <img class="logo" src="/assets/logo.png" alt="University logo" />
        <h1 class="logo-text">Dashboard</h1>
      </div>
      <div class="separator">
        <hr class="solid" />
      </div>
      <div class="dashboard-list">
        <div class="not-flex">
          <Link href="/dashboard" class="dashboard"><i class="fa fa-home"></i>Dashboard</Link>
          <Link href="/student-list" class="lists"><i class="fa fa-bar-chart"></i>Student Lists</Link>
          <Link href="/add-new" class="add-new"><i class="fa fa-plus"></i>Add new</Link>
        </div>
      </div>
      <div class="cta-button-dashboard">
        <i class="fa fa-plus not-circle"></i>
        <h1 class="cta-button-dashboard-head">Add new</h1>
        <p class="cta-text">Add new student info</p>
        <Link href="/add-new" class="button-1">Click here</Link>
      </div>
    </div>

    <div class="inner-container second-column">
      <div class="page-info flex">
        <h1 class="main-title"><span class="gray">Pages</span> / Edit Student</h1>
        <div class="admin-setting flex">
          <div class="search-bar">
            <i class="fa fa-search"></i>
            <input v-model="search" class="main-input" type="text" placeholder="Search" />
          </div>
          <ul class="admin-icons flex">
            <Link href="/profile" class="admin">
              <i class="fa fa-user admin-user-icon"></i>admin
            </Link>
            <div class="cog-icon" @click="toggleModal">⚙️</div>
            <div v-if="showModal" class="modal" id="modal">
              <div class="modal-content">
                <span class="close" @click="toggleModal">&times;</span>
                <div class="profile-picture">
                  <div class="avatar">
                    <i class="fa fa-user-circle"></i>
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
          <h2>Edit Student Information</h2>
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
              <label>Birth Date</label>
              <input v-model="form.birth_date" type="date" required />
              <div v-if="errors.birth_date" class="error">{{ errors.birth_date }}</div>
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
              <input v-model="form.daily_fare" type="number" min="0" step="0.01" />
              <div v-if="errors.daily_fare" class="error">{{ errors.daily_fare }}</div>
            </div>
            <div class="form-group">
              <label>Monthly Rental Cost (if renting)</label>
              <input v-model="form.monthly_rental" type="number" min="0" step="0.01" />
              <div v-if="errors.monthly_rental" class="error">{{ errors.monthly_rental }}</div>
            </div>
            <div class="form-group">
              <label>Family Income Bracket</label>
              <select v-model="form.family_income_bracket" required>
                <option value="">Select Income Bracket</option>
                <option value="Below ₱10,000">Below ₱10,000</option>
                <option value="₱10,000 - ₱30,000">₱10,000 - ₱30,000</option>
                <option value="₱30,000 - ₱50,000">₱30,000 - ₱50,000</option>
                <option value="Above ₱50,000">Above ₱50,000</option>
              </select>
              <div v-if="errors.family_income_bracket" class="error">{{ errors.family_income_bracket }}</div>
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
            <div class="form-group">
              <label>Family Income (Annual)</label>
              <input type="number" v-model="form.family_income" required min="0" step="0.01">
              <div v-if="errors.family_income" class="error">{{ errors.family_income }}</div>
            </div>
          </div>
          <div class="button-container">
            <button type="submit" class="button-add" :disabled="processing">
              {{ processing ? 'Updating...' : 'Update Student' }}
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

const props = defineProps({
  student: {
    type: Object,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
});

const showModal = ref(false);
const search = ref('');
const processing = ref(false);

// Initialize form with existing student data
const form = useForm({
  first_name: props.student?.first_name || '',
  middle_name: props.student?.middle_name || '',
  last_name: props.student?.last_name || '',
  student_id: props.student?.student_id || '',
  course: props.student?.course || '',
  year_level: props.student?.year_level || '',
  gender: props.student?.gender || '',
  birth_date: props.student?.birth_date || '',
  marital_status: props.student?.marital_status || 'Single',
  religion: props.student?.religion || '',
  cellphone_number: props.student?.cellphone_number || '',
  address: props.student?.address || '',
  barangay: props.student?.barangay || '',
  city: props.student?.city || '',
  province: props.student?.province || '',
  postal_code: props.student?.postal_code || '',
  study_device: props.student?.study_device || '',
  is_solo_parent: props.student?.is_solo_parent || false,
  solo_parent_id: props.student?.solo_parent_id || '',
  has_part_time_job: props.student?.has_part_time_job || false,
  daily_fare: props.student?.daily_fare || 0,
  monthly_rental: props.student?.monthly_rental || 0,
  family_income_bracket: props.student?.family_income_bracket || '',
  household_size: props.student?.household_size || '',
  transportation_mode: props.student?.transportation_mode || '',
  travel_time_minutes: props.student?.travel_time_minutes || '',
  ethnicity: props.student?.ethnicity || '',
  pwd: props.student?.pwd || false,
  pwd_id: props.student?.pwd_id || '',
  housing_status: props.student?.housing_status || '',
  family_income: props.student?.family_income || 0,
});

const toggleModal = () => {
  showModal.value = !showModal.value;
};

const submitForm = () => {
  processing.value = true;
  form.put(`/student/${props.student.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      processing.value = false;
    },
    onError: () => {
      processing.value = false;
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
  box-sizing: border-box;
}

.container-1 {
  min-height: 100vh;
  display: flex;
  background-color: #F8F9FA;
  gap: 24px;
  padding: 24px;
}

.first-column {
  width: 280px;
  background: white;
  padding: 24px;
  border-radius: 8px;
  height: fit-content;
}

.second-column {
  flex: 1;
  background: white;
  padding: 24px;
  border-radius: 8px;
}

.logo-sec {
  display: flex;
  align-items: center;
  margin-bottom: 32px;
}

.logo {
  width: 40px;
  height: 40px;
}

.logo-text {
  margin-left: 12px;
  color: #2D3748;
  font-size: 18px;
  font-weight: 600;
}

.dashboard-list {
  margin-bottom: 32px;
}

.dashboard-list .not-flex {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.dashboard-list a {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #4A5568;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 6px;
  transition: all 0.2s;
}

.dashboard-list a:hover {
  background: #EDF2F7;
}

.dashboard-list i {
  width: 20px;
}

.page-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}

.main-title {
  font-size: 24px;
  color: #2D3748;
}

.main-title .gray {
  color: #718096;
}

.admin-setting {
  display: flex;
  align-items: center;
  gap: 24px;
}

.search-bar {
  position: relative;
}

.search-bar i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
}

.main-input {
  padding: 8px 12px 8px 36px;
  border: 1px solid #E2E8F0;
  border-radius: 6px;
  width: 240px;
}

.admin-icons {
  display: flex;
  align-items: center;
  gap: 16px;
}

.admin {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #4A5568;
  text-decoration: none;
}

.cog-icon {
  cursor: pointer;
  font-size: 20px;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 24px;
  border-radius: 8px;
  width: 320px;
  text-align: center;
}

.close {
  float: right;
  cursor: pointer;
  font-size: 24px;
}

.avatar {
  font-size: 48px;
  color: #4A5568;
  margin: 16px 0;
}

.sign-out {
  display: inline-block;
  margin-top: 16px;
  padding: 8px 16px;
  background: #E53E3E;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-decoration: none;
}

.add-student-info {
  background: white;
  padding: 24px;
  border-radius: 8px;
}

.add-student-info h2 {
  color: #2D3748;
  font-size: 20px;
  margin-bottom: 24px;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-bottom: 32px;
}

.form-group {
  margin-bottom: 0;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #4A5568;
  font-weight: 500;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #E2E8F0;
  border-radius: 6px;
  font-size: 14px;
  color: #2D3748;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: #4299E1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.error {
  color: #E53E3E;
  font-size: 12px;
  margin-top: 4px;
}

.button-container {
  text-align: right;
}

.button-add {
  background: #48BB78;
  color: white;
  padding: 10px 24px;
  border: none;
  border-radius: 6px;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s;
}

.button-add:hover {
  background: #38A169;
}

.button-add:disabled {
  background: #A0AEC0;
  cursor: not-allowed;
}

.custom-control {
  position: relative;
  padding-left: 32px;
  margin-top: 8px;
}

.custom-control-input {
  position: absolute;
  opacity: 0;
}

.custom-control-label {
  position: relative;
  cursor: pointer;
  padding-top: 3px;
}

.custom-control-label::before {
  position: absolute;
  left: -32px;
  top: 2px;
  width: 20px;
  height: 20px;
  background: white;
  border: 2px solid #CBD5E0;
  border-radius: 4px;
  content: '';
}

.custom-control-input:checked ~ .custom-control-label::before {
  background: #48BB78;
  border-color: #48BB78;
}

.custom-control-input:checked ~ .custom-control-label::after {
  position: absolute;
  left: -28px;
  top: 6px;
  width: 12px;
  height: 12px;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
  background-size: cover;
  content: '';
}

.cta-button-dashboard {
  background: #EDF2F7;
  padding: 24px;
  border-radius: 8px;
  text-align: center;
  margin-top: 32px;
}

.not-circle {
  font-size: 24px;
  color: #4A5568;
  margin-bottom: 16px;
}

.cta-button-dashboard-head {
  font-size: 18px;
  color: #2D3748;
  margin-bottom: 8px;
}

.cta-text {
  color: #718096;
  font-size: 14px;
  margin-bottom: 16px;
}

.button-1 {
  display: inline-block;
  padding: 8px 16px;
  background: #4299E1;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  transition: background 0.2s;
}

.button-1:hover {
  background: #3182CE;
}
</style>
