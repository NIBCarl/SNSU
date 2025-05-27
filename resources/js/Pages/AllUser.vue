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
          <h1 class="main-title"><span class="gray">Pages</span> / All users</h1>
          <div class="admin-setting flex">
            <div class="search-bar">
              <i class="fa fa-search"></i>
              <input class="main-input" type="text" value="Search"/>
            </div>
            <ul class="admin-icons flex">
              <router-link to="/admin" class="admin" alt="imo mama">
                <i class="fa fa-user admin-user-icon"></i>admin
              </router-link>
              <div class="cog-icon" id="openModal">
                ⚙️
              </div>
              <div class="modal" id="modal">
                <div class="modal-content">
                  <span class="close" id="closeModal">&times;</span>
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
            </ul>
          </div>
        </div>
        <div class="overview-location">
          <div class="headline-overview-location">
            <H1 class="location-headline">All users</H1>
          </div>
          <div class="overview-content">
            <div class="title-description-over row">
              <div class="loc-1 col">Student</div>
              <div class="loc-1 col">Role</div>
              <div class="loc-1 col">Created</div>
            </div>
            <hr>
            <div class="title-description-over row">
              <div class="col flex student-info-name">
                <i class="fa fa-user admin-user-icon-2"></i>
                <div class="list-inner-content">
                  <div class="loc-3">Rashed Brigole</div>
                  <div class="loc-5">rbrigole2@ssct.edu.ph</div>
                </div>
              </div>
              <div class="col">
                <div class="list-inner-content">
                  <div class="loc-3">Administrative</div>
                </div>
              </div>
              <div class="loc-3 col">2024-12-26</div>
              <router-link to="/edit-user" class="loc-6">edit</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AllUser',
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
.fa-bar-chart {
    font-size: 15px;
    color: #ffffff;
    background-color: #235F23;
    border-radius: 12px;
    padding: 7.5px;
    margin-right: 11.5px;
}
.fa-home, .fa-plus {
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
.cta-button-dashboard .fa-plus {
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

  </style>
  