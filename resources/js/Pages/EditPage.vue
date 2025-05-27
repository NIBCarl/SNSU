<template>
    <div class="container-1">
  <div class="inner-container first-column">
    <div class="logo-sec">
      <img class="logo" src="/assets/logo.png" alt="University logo">
      <h1 class="logo-text">Dashboard</h1>
    </div>
    <div class="separator">
      <hr class="solid">
    </div>
    <div class="dashboard-list">
      <div class="not-flex">
        <router-link to="/" class="dashboard"><i class="fa fa-home"></i>Dashboard</router-link>
        <router-link to="/student-list" class="lists"><i class="fa fa-bar-chart"></i>Student Lists</router-link>
        <router-link to="/add-new" class="add-new"><i class="fa fa-plus"></i>Add new</router-link>
      </div>
    </div>
    <div class="cta-button-dashboard">
      <i class="fa fa-plus not-circle"></i>
      <h1 class="cta-button-dashboard-head">Add new</h1>
      <p class="cta-text">Add new student info</p>
      <router-link to="/add-new" style="color: black;">
        <button class="button-1"><div>Click here</div></button>
      </router-link>
    </div>
  </div>

  <div class="inner-container second-column">
  <div class="page-info flex">
    <h1 class="main-title"><span class="gray">Pages</span> / Edit</h1>
    <div class="admin-setting flex">
      <div class="search-bar">
        <i class="fa fa-search"></i>
        <input class="main-input" type="text" placeholder="Search" />
      </div>
      <ul class="admin-icons flex">
        <router-link class="admin" to="/all-user">
          <i class="fa fa-user admin-user-icon"></i> admin
        </router-link>
        <div class="cog-icon" @click="openModal">⚙️</div>
      </ul>
      <!-- Modal window -->
      <div v-if="showModal" class="modal" @click="closeModal">
        <div class="modal-content" @click.stop>
          <span class="close" @click="closeModal">&times;</span>
          <div class="profile-picture">
            <div class="avatar">
              <i class="fa fa-user-circle"></i>
            </div>
          </div>
          <h2>Admin</h2>
          <p>studentaffairs@ssct.edu.ph</p>
          <router-link to="/sign-in" class="sign-out">Sign out</router-link>
        </div>
      </div>
    </div>
  </div>

  <div class="add-student-info">
    <form>
      <div class="header">
        <div class="profile">
          <div class="avatar">
            <i class="fa fa-user-circle"></i>
          </div>
          <div class="info">
            <h3>Rashed Brigole</h3>
            <p>rbrigole2@ssct.edu.ph</p>
          </div>
        </div>
      </div>

      <!-- Input fields for form -->
      <div class="row">
        <input type="text" placeholder="First Name" value="Rashed" />
        <input type="text" placeholder="Middle Name" value="Tabirao" />
        <input type="text" placeholder="Last Name" value="Brigole" />
      </div>
      <div class="row">
        <input type="text" placeholder="Course" value="BSICT" />
        <input type="text" placeholder="Year Level" value="3A" />
        <select>
          <option selected>Male</option>
          <option>Female</option>
        </select>
        <select>
          <option selected>Single</option>
          <option>Married</option>
        </select>
        <input type="text" placeholder="Religion" value="Catholic" />
      </div>
      <div class="row">
        <label>Do you have a cellphone?</label>
        <label><input type="radio" name="cellphone" value="yes" checked /> Yes</label>
        <label><input type="radio" name="cellphone" value="no" /> No</label>
        <input type="tel" value="+639023485339" placeholder="Indicate cellphone number" />
        <input type="text" value="Android Phone" placeholder="Device used for studying" />
      </div>
      <!-- Additional form fields based on your HTML -->

      <div class="button-container">
        <router-link to="/students">
          <button class="button-add cancel" type="button">Cancel</button>
        </router-link>
        <button class="button-add save" type="submit">Save Changes</button>
      </div>
    </form>
  </div>
</div>
</div>
</template>
<script>
export default {
  name: "EditPage",
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
  },
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
    padding: 40px 10.5px;
    width: 1920px;
    display: flex;
    background-color: #F8F9FA;
    column-gap: 10px;
}
.flex {
    display: flex;
}

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
    width: 10%;
}
.second-column {
    width: 90%;
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
.fa-search {
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
.fa-plus {
    font-size: 15px;
    color: #ffffff;
    background-color: #235F23;
    border-radius: 12px;
    padding: 7.5px;
    margin-right: 11.5px;
}
.fa-bar-chart, .fa-home {
    font-size: 15px;
    color: #235F23;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 7.5px;
    margin-right: 11.5px;
}
.add-new{
    font-size: 12px;
    font-weight: 700;
    color: #2D3748;
    padding: 12px 20px 12px 16px;
    border-radius: 15px;
    box-shadow: 0 3.5px 5.5px 0 rgba(0, 0, 0, 0.2);
}
.lists, .dashboard {
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
.cta-button-dashboard .fa-plus {
    border-radius: 12px;
    font-size: 24px;
    margin-bottom: 21px;
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
    text-transform: uppercase;
    font-weight: 700;
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
    text-transform: uppercase;
    font-size: 12px;
}

input[type="radio"] {
    margin-right: 5px;
}

.button-add {
    text-align: center;
    padding: 17px 52px;
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
    justify-content: flex-end;
    align-items: center;
    margin-top: 20px;
}
.cog-icon {
    font-size: 15px;
    cursor: pointer;
}
.modal {
    display: none;
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
.cancel {
    background-color: #CF142B;
    color: white;
    margin-right: 20px;
}

.cancel:hover {
    background-color: #CF142B;
}

.save {
    background-color: #235F23;
    color: white;
}

.save:hover {
    background-color: #235F23;
}
.profile {
    display: flex;
    align-items: center;
    margin-bottom: 41px;
}
.fa-user-circle {
    font-size: 73px;
    color: #ffffff;
}
.avatar {
    background-color: #235F23;
    padding: 26px;
    margin-right: 18px;
    border-radius: 12px;
}
  </style>
  