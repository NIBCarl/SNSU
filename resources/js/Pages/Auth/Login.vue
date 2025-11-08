<template>
    <div class="sign-in-screen">
        <div class="student-registration-link">
            <a href="/" class="registration-link">Student Registration</a>
        </div>
        <div class="new-design-wrapper">
            <div class="new-design">
                <div class="main-dashboard">
                    <img class="image" alt="University Logo" src="/assets/logo2.png" />
                    <div class="sign-in-form inputs">
                        <h1 class="welcome">Welcome Back</h1>
                        <p class="instruction">Enter your email and password to sign in</p>
                        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
                        <form @submit.prevent="handleSignIn">
                            <label>Email</label>
                            <input
                                type="email"
                                v-model="form.email"
                                placeholder="Your email"
                                class="input-field"
                                required
                            />
                            <label>Password</label>
                            <input
                                type="password"
                                v-model="form.password"
                                placeholder="Your password"
                                class="input-field"
                                required
                            />
                            <div class="options">
                                <div class="toggle-switch">
                                    <label class="switch">
                                        <input
                                            type="checkbox"
                                            v-model="form.remember"
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                    <p>Remember me</p>
                                </div>
                            </div>
                            <button type="submit" class="button" :disabled="form.processing">SIGN IN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const errorMessage = ref('');

const handleSignIn = () => {
    form.post('/login', {
        onError: (errors) => {
            if (errors.email) {
                errorMessage.value = errors.email;
            } else if (errors.password) {
                errorMessage.value = errors.password;
            }
        },
        preserveScroll: true
    });
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
body {
  font-family: 'Poppins';
  margin: 0;
  padding: 0;
}
.sign-in-screen {
  background-color: transparent;
  display: flex;
  flex-direction: row;
  justify-content: center;
  width: 100%;
}

.sign-in-screen .new-design-wrapper {
  height: 1052.5px;
  width: 1920px;
}

.sign-in-screen .new-design {
  height: 1052px;
}

.sign-in-screen .main-dashboard {
  background-color: #ffffff;
  height: 1052px;
  position: relative;
  width: 1920px;
}


.sign-in-screen .image {
  height: 1052px;
  left: 1058px;
  position: absolute;
  top: 0;
  width: 862px;
  background-color: rgba(255, 247, 185, 0.2);
}

.sign-in-screen .inputs {
  height: 404px;
  left: 466px;
  position: relative;
  top: 282px;
  width: 353px;
}


.sign-in-screen {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.sign-in-container {
  background-color: white;
  padding: 50px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 400px;
  text-align: center;
}

.welcome {
  color: #235f23;
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 0;
}

.instruction {
  color: #A0AEC0;
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 30px;
}

/* ===== ENHANCED LOGIN INPUT FIELDS WITH DEPTH ===== */
.input-field {
  font-family: 'Poppins';
  width: 100%;
  padding: 14px 20px;
  margin-bottom: 20px;
  border-radius: 12px;
  border: 1px solid #E2E8F0;
  font-size: 14px;
  color: #2D3748;
  margin-top: 8px;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  transition: all 0.2s ease;
  box-sizing: border-box;
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
  color: #2D3748;
  /* Glowing effect on focus */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 0 0 3px rgba(35, 95, 35, 0.1),
    0 2px 4px rgba(0, 0, 0, 0.05);
  transform: translateY(-1px);
}

.options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}
.toggle-switch  {
  display: flex;
  align-items: center;
}

.toggle-switch input {
  margin-right: 10px;
}

.create-new-user {
  font-size: 14px;
  color: #A0AEC0;
  text-decoration: underline;
}

/* ===== ENHANCED LOGIN BUTTON WITH PROMINENCE ===== */
.button {
  font-family: 'Poppins';
  width: 100%;
  padding: 16px;
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
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 4px 8px rgba(35, 95, 35, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
}

.button:hover:not(:disabled) {
  background: linear-gradient(to bottom, #3a9a3a 0%, #2d7d2d 100%);
  /* Bigger shadow on hover for prominence */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.3) inset,
    0 6px 12px rgba(35, 95, 35, 0.4),
    0 3px 6px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

.button:active:not(:disabled) {
  transform: translateY(0);
  /* Inset shadow to appear pressed */
  box-shadow: 
    0 2px 4px rgba(0, 0, 0, 0.2) inset,
    0 1px 2px rgba(0, 0, 0, 0.1);
}

.button:disabled {
  background: linear-gradient(to bottom, #cbd5e0 0%, #a0aec0 100%);
  cursor: not-allowed;
  box-shadow: none;
  transform: none;
}
.switch {
  position: relative;
  display: inline-block;
  width: 36px;
  height: 18.5px;
  margin-right: 10px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13.5px;
  width: 13.5px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #235f21;
}

input:focus + .slider {
  box-shadow: 0 0 1px #235f21;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13.5px);
  -ms-transform: translateX(13.5px);
  transform: translateX(13.5px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.student-registration-link {
  position: absolute;
  top: 20px;
  right: 40px;
  z-index: 1000;
}

/* ===== ENHANCED REGISTRATION LINK WITH DEPTH ===== */
.registration-link {
  color: #235f23;
  font-size: 14px;
  font-weight: 700;
  text-decoration: none;
  padding: 12px 24px;
  border: 2px solid #235f23;
  border-radius: 10px;
  transition: all 0.2s ease;
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
  /* Small shadow for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 4px rgba(0, 0, 0, 0.06);
}

.registration-link:hover {
  background: linear-gradient(to bottom, #2d7d2d 0%, #235F23 100%);
  color: white;
  border-color: #235f23;
  /* Bigger shadow on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.2) inset,
    0 4px 8px rgba(35, 95, 35, 0.3),
    0 2px 4px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}
</style>