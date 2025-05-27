<template>
    <div class="sign-in-screen">
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
  height: 872px;
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

.input-field {
  font-family: 'Poppins';
  width: 100%;
  padding: 15.25px 0px 15.25px 20px;
  margin-bottom: 20px;
  border-radius: 15px;
  border: 1px solid #E2E8F0;
  font-size: 14px;
  color: #A0AEC0;
  margin-top: 6px;
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

.button {
  font-family: 'Poppins';
  width: 100%;
  padding: 15px;
  background-color: #235f23;
  color: white;
  font-size: 10px;
  font-weight: 700;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.button:hover {
  background-color: #1e501d;
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
</style>