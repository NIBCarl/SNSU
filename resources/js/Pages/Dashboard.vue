<template>
  <Head title="Dashboard" />
  <div class="container-1">
    <!-- Sidebar -->
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
            <Link href="/student-list" class="lists"><i class="fas fa-chart-bar"></i>Student Lists</Link>
            <Link href="/add-new" class="add-new"><i class="fas fa-plus"></i>Add new</Link>
          </div>
        </div>
        <div class="cta-button-dashboard">
          <i class="fas fa-plus not-circle"></i>
          <h1 class="cta-button-dashboard-head">Add new</h1>
          <p class="cta-text">Add new student info</p>
          <Link href="/add-new" style="text-decoration: none; color: black;">
            <button class="button-1">
              <div class="">Click here</div>
            </button>
          </Link>
        </div>
      </div>
    </Transition>
    <div class="inner-container second-column" :class="{ 'content-shifted': isSidebarOpen, 'content-full': !isSidebarOpen }">
      <div class="page-info flex items-center">
        <!-- Hamburger Icon -->
        <button @click="toggleSidebar" class="p-2 mr-4 text-gray-600 hover:text-gray-800 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Dashboard</h1>
        <div class="admin-setting flex">
          <div class="search-bar">
            <i class="fas fa-search"></i>
            <input class="main-input" type="text" v-model="searchQuery" placeholder="Search" />
          </div>
          <ul class="admin-icons flex">
            <Link href="/profile" class="admin">
              <i class="fas fa-user admin-user-icon"></i>admin
            </Link>
            <div class="cog-icon" @click="toggleModal">⚙️</div>
            <div class="modal" v-if="openModal">
              <div class="modal-content">
                <span class="close" @click="openModal = false">&times;</span>
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
      <div class="dashboard-stats">
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
              <h3>Total Students</h3>
              <p>{{ totals.totalStudents }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <div class="stat-info">
              <h3>Indigenous Students</h3>
              <p>{{ totals.indigenousPeople }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-wheelchair"></i>
            </div>
            <div class="stat-info">
              <h3>PWD Students</h3>
              <p>{{ totals.pwd }}</p>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-home"></i>
            </div>
            <div class="stat-info">
              <h3>Renting Students</h3>
              <p>{{ totals.renting }}</p>
            </div>
          </div>
        </div>
        <div class="charts-grid">
          <div class="chart-container">
            <h3>Student Demographics</h3>
            <div style="position: relative; height: 300px;">
              <canvas id="demographicsChart"></canvas>
            </div>
          </div>
          <div class="chart-container">
            <h3>Income Distribution</h3>
            <div style="position: relative; height: 300px;">
              <canvas id="incomeChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="total-icons flex">
        <div class="total-cont flex">
          <div class="total-content">
            <h1 class="sub-headline">Total records</h1>
            <h1 class="headline-total">{{ totals.totalStudents }}</h1>
          </div>
          <i class="fas fa-user icon-design"></i>
        </div>
        <div class="total-cont flex">
          <div class="total-content">
            <h1 class="sub-headline">Indigenous People</h1>
            <h1 class="headline-total">{{ totals.indigenousPeople }}</h1>
          </div>
          <i class="fas fa-user icon-design"></i>
        </div>
        <div class="total-cont flex">
          <div class="total-content">
            <h1 class="sub-headline">Person with Disability</h1>
            <h1 class="headline-total">{{ totals.pwd }}</h1>
          </div>
          <i class="fas fa-user icon-design"></i>
        </div>
        <div class="total-cont flex">
          <div class="total-content">
            <h1 class="sub-headline">Renting a House</h1>
            <h1 class="headline-total">{{ totals.renting }}</h1>
          </div>
          <i class="fas fa-user icon-design"></i>
        </div>
      </div>
      <div class="dashboard-text">
        <div class="dashboard-text-inner">
          <div class="overlap-group-2">
            <div class="text-wrapper-2">Dashboard</div>
            <p class="p">
              The SNSU Student Insights project is focused on developing a secure and exclusive system
              for the Student Affairs Office staff to collect, analyze, and manage critical demographic
              data of students. This system will ensure student privacy and data security, making sure
              only authorized staff have access to sensitive information.
            </p>
            <button class="button" @click="toggleModal"><div class="text-3">Read more</div></button>
          </div>
          <div class="image-dashboard">
            <img class="img-dashboard-first" src="/assets/logo.png" />
          </div>
        </div>
        <div class="dashboard-text-inner-2">
          <div class="overlap-group-3">
            <div class="text-wrapper-2-socio">Socio Demographic</div>
            <div class="text-wrapper-2-2">{{ totals.totalStudents }}</div>
            <p class="p-1">Total Students</p>
          </div>
          <div class="charlang">
            <div class="chart">
              <canvas id="doughnut"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="overview-location">
        <div class="headline-overview-location">
          <h1 class="location-headline">Location</h1>
          <a class="admin" href="#"><i class="fas fa-map-marker map-marker-icon"></i>Student address</a>
        </div>
        <div class="overview-content">
          <div class="title-description-over row">
            <div class="loc-1 col">Location</div>
            <div class="loc-1 col">Total</div>
            <div class="loc-1 col">Income/Year</div>
            <div class="loc-1 col">Percentage</div>
          </div>
          <hr>
          <template v-for="location in locations" :key="location.name">
            <div class="title-description-over row">
              <div class="loc-3 col">{{ location.name }}</div>
              <div class="loc-3 col">{{ location.total }}</div>
              <div class="loc-3 col">{{ location.income }}</div>
              <div class="loc-4 col">{{ location.percentage }}%</div>
            </div>
            <hr>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted, watch, onUnmounted, nextTick } from 'vue';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';

const isSidebarOpen = ref(true); // Default: sidebar is open

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const props = defineProps({
  auth: Object,
  stats: Object,
  locationStats: Array
});

const searchQuery = ref('');
const openModal = ref(false);
const totals = ref({
  totalStudents: 0,
  indigenousPeople: 0,
  pwd: 0,
  renting: 0
});

const locations = ref([]);
let demographicsChart = null;
let incomeChart = null;

const updateStats = async () => {
  try {
    const response = await fetch('/dashboard-stats');
    const data = await response.json();
    totals.value = {
      totalStudents: data.totalStudents || 0,
      indigenousPeople: data.indigenousPeople || 0,
      pwd: data.pwd || 0,
      renting: data.renting || 0
    };
    // Only update charts after data is updated
    nextTick(() => {
      updateCharts();
    });
  } catch (error) {
    console.error('Error fetching dashboard stats:', error);
  }
};

const updateLocations = async () => {
  try {
    const response = await fetch('/location-stats');
    const data = await response.json();
    locations.value = data;
    // Only update charts after data is updated
    nextTick(() => {
      updateCharts();
    });
  } catch (error) {
    console.error('Error fetching location stats:', error);
  }
};

const updateCharts = () => {
  // Destroy existing charts first
  if (demographicsChart) {
    demographicsChart.destroy();
    demographicsChart = null;
  }
  if (incomeChart) {
    incomeChart.destroy();
    incomeChart = null;
  }

  // Create demographics chart
  const demoCtx = document.getElementById('demographicsChart');
  if (demoCtx) {
    demographicsChart = new Chart(demoCtx, {
      type: 'pie',
      data: {
        labels: ['Indigenous', 'PWD', 'Renting'],
        datasets: [{
          data: [
            totals.value.indigenousPeople,
            totals.value.pwd,
            totals.value.renting
          ],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12
            }
          }
        }
      }
    });
  }

  // Create income chart
  const incomeCtx = document.getElementById('incomeChart');
  if (incomeCtx && locations.value.length > 0) {
    incomeChart = new Chart(incomeCtx, {
      type: 'bar',
      data: {
        labels: locations.value.map(loc => loc.name),
        datasets: [{
          label: 'Average Income',
          data: locations.value.map(loc => {
            const income = typeof loc.income === 'string' 
              ? parseFloat(loc.income.replace(/[^0-9.]/g, '')) 
              : loc.income;
            return income || 0;
          }),
          backgroundColor: '#4e73df',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Income (PHP)'
            }
          }
        }
      }
    });
  }
};

const toggleModal = () => {
  openModal.value = !openModal.value;
};

const logout = () => {
  router.post('/logout');
};

onMounted(() => {
  // Initial data load
  if (props.stats) {
    totals.value = {
      totalStudents: props.stats.totalStudents || 0,
      indigenousPeople: props.stats.indigenousPeople || 0,
      pwd: props.stats.pwd || 0,
      renting: props.stats.renting || 0
    };
  }
  if (props.locationStats) {
    locations.value = props.locationStats;
  }

  // Initial chart creation after DOM is ready
  nextTick(() => {
    updateCharts();
  });

  // Set up polling for real-time updates
  const pollInterval = 30000; // 30 seconds
  const pollData = async () => {
    await updateStats();
    await updateLocations();
  };

  // Start polling
  const intervalId = setInterval(pollData, pollInterval);

  // Cleanup on component unmount
  onUnmounted(() => {
    clearInterval(intervalId);
    if (demographicsChart) {
      demographicsChart.destroy();
      demographicsChart = null;
    }
    if (incomeChart) {
      incomeChart.destroy();
      incomeChart = null;
    }
  });
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Poppins');

* {
  margin: 0;
  padding: 0;
  font-family: 'Poppins';
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

.flex {
  display: flex;
}

.inner-container {
}

.first-column {
  flex-shrink: 0;
  width: 280px;
  padding: 1rem;
}

.second-column {
  flex-grow: 1;
  padding: 1rem;
  overflow-x: auto;
}

@media (max-width: 768px) {
  .container-1 {
    flex-direction: column;
    padding: 0.5rem;
    gap: 0.5rem;
  }
  .first-column {
    width: 100%; /* On mobile, when open, it could be full width or a set width */
    /* position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; for an overlay effect */
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
  /* Hide hamburger on mobile if sidebar takes full screen when open, or adjust its position */
  .page-info {
    flex-direction: column;
    align-items: flex-start;
  }
  .admin-setting {
    width: 100%;
    margin-top: 1rem;
  }
  .search-bar {
    width: 100%;
    margin-right: 0;
    margin-bottom: 0.5rem;
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
.fas {
  color: #2D3748;
  padding-right: 12.68px;
}   
.admin-setting {
  align-items: center;
}
.admin-user-icon, .fas {
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
.fas {
  font-size: 15px;
  color: #ffffff;
  background-color: #235F23;
  border-radius: 12px;
  padding: 7.5px;
  margin-right: 11.5px;
}
.fas {
  font-size: 15px;
  color: #235F23;
  background-color: #ffffff;
  border-radius: 12px;
  padding: 7.5px;
  margin-right: 11.5px;
}
.dashboard{
  font-size: 12px;
  font-weight: 700;
  color: #2D3748;
  padding: 12px 20px 12px 16px;
  border-radius: 15px;
  box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
}
.lists, .add-new {
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
.overview-location {
  padding: 28px 32px;
  box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
  border-radius: 12px;
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
.cta-button-dashboard .fas {
  border-radius: 12px;
  font-size: 24px;
  margin-bottom: 21px;
}
.cog-icon {
  font-size: 15px;
  cursor: pointer;
  z-index: 1000;
  position: relative;
  pointer-events: auto;
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
  font-size: 22px;
  color: #4b4b4b;
  margin-bottom: 5px;
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

.stats-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.stat-card {
  flex: 1 1 200px;
  background: white;
  padding: 24px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 16px;
}

.stat-icon {
  width: 48px;
  height: 48px;
  background: #EBF8FF;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #4299E1;
  font-size: 24px;
}

.stat-info h3 {
  font-size: 14px;
  color: #718096;
  margin-bottom: 4px;
}

.stat-info p {
  font-size: 24px;
  font-weight: 600;
  color: #2D3748;
}

.charts-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.chart-container {
  flex: 1 1 300px;
  min-width: 280px;
  background: white;
  padding: 24px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.chart-container h3 {
  font-size: 18px;
  color: #2D3748;
  margin-bottom: 16px;
}

/* Force Font Awesome styles for icons in this component */
/* General rule for all i tags with Font Awesome classes within this component */
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

/* fab (Brand icons) usually have their own weight defined by FA, but can be 400 too */
i.fab {
    font-weight: 400 !important; /* Or as appropriate for brand icons */
}

.total-icons {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.total-cont {
  flex: 1 1 200px;
}

.dashboard-text {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.dashboard-text-inner,
.dashboard-text-inner-2 {
  flex: 1 1 300px;
  min-width: 280px;
}

.overview-location .row {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 1px solid #e2e8f0;
  padding: 0.5rem 0;
}

.overview-location .col {
  flex: 1 1 100px;
  padding: 0.25rem 0.5rem;
  min-width: 90px;
}

@media (max-width: 480px) {
  .overview-location .row {
    flex-direction: column;
    align-items: flex-start;
  }
  .overview-location .col {
    width: 100%;
    padding-left: 0;
    border-bottom: 1px dotted #e2e8f0;
  }
  .overview-location .col:last-child {
    border-bottom: none;
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
  transform: translateX(-280px); /* Slide out to the left */
  opacity: 0;
}

/* Adjust second-column based on sidebar visibility for desktop */
.content-full {
  width: 100%;
  margin-left: 0;
}
.content-shifted {
  /* This might not be strictly necessary if the .first-column is part of the flex layout 
     and .second-column uses flex-grow. However, explicit control can be useful. */
  /* margin-left: 280px; /* Width of the sidebar */ 
  /* width: calc(100% - 280px); */
}
</style>