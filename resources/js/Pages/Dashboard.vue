<template>
  <Head title="Dashboard" />
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
            <Link href="/dashboard" class="lists"><i class="fas fa-home"></i>Dashboard</Link>
            <Link href="/student-list" class="dashboard"><i class="fas fa-chart-bar"></i>Student Lists</Link>
            <Link href="/add-new" class="dashboard"><i class="fas fa-plus"></i>Add new</Link>
          </div>
        </div>
        <AddNewCTA />
      </div>
    </Transition>
    <div class="inner-container second-column" :class="{ 'content-shifted': isSidebarOpen, 'content-full': !isSidebarOpen }">
      <div class="page-info flex items-center">
        <!-- Hamburger Icon -->
        <button @click="toggleSidebar" class="hamburger-button">
          <svg class="hamburger-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <h1 class="main-title"><span class="gray">Pages</span> / Dashboard</h1>
        <div class="admin-setting flex">
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
      <!-- Stats Cards -->
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
      </div>

      <!-- Dashboard Info & Charts Section -->
      <div class="dashboard-content-row">
        <div class="dashboard-text-inner">
          <div class="overlap-group-2">
            <div class="text-wrapper-2">Dashboard</div>
            <p class="p">
              The SNSU Student Insights project is focused on developing a secure and exclusive system
              for the Student Affairs Office staff to collect, analyze, and manage critical demographic
              data of students. This system will ensure student privacy and data security, making sure
              only authorized staff have access to sensitive information.
            </p>
          </div>
          <div class="image-dashboard">
            <img class="img-dashboard-first" src="/assets/logo.png" />
          </div>
        </div>
        <div class="charts-column">
          <div class="chart-container">
            <h3>Student Demographics</h3>
            <div style="position: relative; height: 300px;">
              <canvas id="demographicsChart"></canvas>
            </div>
          </div>
          <div class="chart-container">
            <h3>Solo Parent Distribution</h3>
            <div style="position: relative; height: 300px;">
              <canvas id="soloParentChart"></canvas>
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
            <div class="loc-1 col">Indigenous</div>
            <div class="loc-1 col">PWD</div>
            <div class="loc-1 col">Solo Parent</div>
            <div class="loc-1 col">Percentage</div>
          </div>
          <hr>
          <template v-for="location in locations" :key="location.name">
            <div class="title-description-over row">
              <div class="loc-3 col">{{ location.name }}</div>
              <div class="loc-3 col">{{ location.total }}</div>
              <div class="loc-3 col">{{ location.indigenous }}</div>
              <div class="loc-3 col">{{ location.pwd }}</div>
              <div class="loc-3 col">{{ location.soloParent }}</div>
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
  if (window.innerWidth > 768) {
    isSidebarOpen.value = true;
  } else {
    isSidebarOpen.value = false;
  }
};

const props = defineProps({
  auth: Object,
  stats: Object,
  locationStats: Array
});

const openModal = ref(false);
const totals = ref({
  totalStudents: 0,
  indigenousPeople: 0,
  pwd: 0,
  renting: 0
});

const locations = ref([]);
let demographicsChart = null;
let soloParentChart = null;

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
  if (soloParentChart) {
    soloParentChart.destroy();
    soloParentChart = null;
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

  // Create solo parent chart
  const soloParentCtx = document.getElementById('soloParentChart');
  if (soloParentCtx && locations.value.length > 0) {
    soloParentChart = new Chart(soloParentCtx, {
      type: 'bar',
      data: {
        labels: locations.value.map(loc => loc.name),
        datasets: [{
          label: 'Solo Parent Count',
          data: locations.value.map(loc => loc.soloParent || 0),
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
            ticks: {
              stepSize: 1
            },
            title: {
              display: true,
              text: 'Number of Solo Parents'
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
  
  // Add resize listener for sidebar
  window.addEventListener('resize', handleResize);

  // Cleanup on component unmount
  onUnmounted(() => {
    clearInterval(intervalId);
    window.removeEventListener('resize', handleResize);
    if (demographicsChart) {
      demographicsChart.destroy();
      demographicsChart = null;
    }
    if (soloParentChart) {
      soloParentChart.destroy();
      soloParentChart = null;
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
  background-color: white; /* Added for consistency with AddNew page */
  border-radius: 15px; /* Added for card-like appearance matching AddNew */
}

.second-column {
  flex-grow: 1;
  padding: 1rem;
  overflow-x: auto;
  background-color: white; /* Added for consistency with AddNew page */
  border-radius: 15px; /* Added for card-like appearance matching AddNew */
}

/* ===== MOBILE SIDEBAR AS OVERLAY ===== */
@media (max-width: 768px) {
  .container-1 {
    position: relative;
    flex-direction: row;
    padding: 0;
    gap: 0;
  }
  
  /* Sidebar as overlay on mobile */
  .first-column,
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
    animation: fadeInBackdrop 0.3s ease;
  }
  
  @keyframes fadeInBackdrop {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
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
  }
  .search-bar {
    width: 100%;
    margin-right: 0;
    margin-bottom: 0.5rem;
  }
  
  /* Content takes full width on mobile */
  .second-column {
    width: 100% !important;
    padding: 0.5rem;
    margin-left: 0 !important;
  }
  
  /* Ensure hamburger is always visible on mobile */
  .hamburger-button {
    display: flex !important;
    margin-right: 0.75rem;
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
.lists .fas.fa-home {
  font-size: 15px;
  color: #ffffff;
  background-color: #235F23;
  border-radius: 12px;
  padding: 7.5px;
  margin-right: 11.5px;
}
.dashboard .fas.fa-chart-bar, 
.dashboard .fas.fa-plus {
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
h1 {
  margin: 0;
}
.dashboard-stats {
  margin-top: 24px;
  margin-bottom: 24px;
}
.dashboard-content-row {
  display: flex;
  gap: 20px;
  margin-top: 24px;
  margin-bottom: 24px;
  align-items: flex-start;
}
.dashboard-text-inner {
  flex: 1;
  display: flex;
  padding: 24px;
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  /* Layered shadow for depth */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
  border-radius: 15px;
  column-gap: 50px;
  min-width: 0;
  transition: all 0.3s ease;
}

.dashboard-text-inner:hover {
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.95) inset,
    0 8px 16px rgba(0, 0, 0, 0.1),
    0 3px 6px rgba(0, 0, 0, 0.06);
}
.charts-column {
  flex: 1;
  display: flex;
  flex-direction: row;
  gap: 20px;
  min-width: 0;
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
  color: #383838;
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
.title-description-over {
  display: flex;  
  justify-content: flex-start;
}
/* ===== ENHANCED LOCATION OVERVIEW WITH DEPTH ===== */
.overview-location {
  padding: 28px 32px;
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  /* Layered shadow for depth */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
  border-radius: 15px;
  margin-top: 24px;
  transition: all 0.3s ease;
}

.overview-location:hover {
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.95) inset,
    0 8px 16px rgba(0, 0, 0, 0.1),
    0 3px 6px rgba(0, 0, 0, 0.06);
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
/* CTA button styles moved to AddNewCTA.vue component */
.cog-icon {
  font-size: 15px;
  cursor: pointer;
  z-index: 1000;
  position: relative;
  pointer-events: auto;
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

.stats-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 24px;
}

/* ===== ENHANCED STAT CARDS WITH DEPTH ===== */
.stat-card {
  flex: 1 1 200px;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  padding: 24px;
  border-radius: 15px;
  /* Layered shadow for depth - light glow on top, dark shadow at bottom */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
  display: flex;
  align-items: center;
  gap: 16px;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.95) inset,
    0 10px 20px rgba(0, 0, 0, 0.12),
    0 4px 8px rgba(0, 0, 0, 0.08);
}

.stat-icon {
  width: 52px;
  height: 52px;
  background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white !important;
  font-size: 24px;
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 4px 8px rgba(35, 95, 35, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-icon i {
  color: white !important;
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

/* ===== ENHANCED CHART CONTAINERS WITH DEPTH ===== */
.chart-container {
  flex: 1;
  background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
  padding: 24px;
  border-radius: 15px;
  /* Layered shadow for depth */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.9) inset,
    0 6px 12px rgba(0, 0, 0, 0.08),
    0 2px 4px rgba(0, 0, 0, 0.05);
  min-width: 0;
  transition: all 0.3s ease;
}

.chart-container:hover {
  /* Slight elevation on hover */
  box-shadow: 
    0 1px 3px rgba(255, 255, 255, 0.95) inset,
    0 8px 16px rgba(0, 0, 0, 0.1),
    0 3px 6px rgba(0, 0, 0, 0.06);
}

.chart-container h3 {
  font-size: 16px;
  font-weight: 700;
  color: #2D3748;
  margin-bottom: 16px;
  margin-top: 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 14px;
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

/* Responsive styles for dashboard content */
@media (max-width: 1400px) {
  .dashboard-content-row {
    flex-direction: column;
  }
  
  .dashboard-text-inner {
    width: 100%;
  }
  
  .charts-column {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .charts-column {
    flex-direction: column;
  }
  
  .chart-container {
    width: 100%;
  }
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
  margin-left: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth expansion */
}
.content-shifted {
  /* This might not be strictly necessary if the .first-column is part of the flex layout 
     and .second-column uses flex-grow. However, explicit control can be useful. */
  /* margin-left: 280px; /* Width of the sidebar */ 
  /* width: calc(100% - 280px); */
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth transition */
}
</style>