<template>
  <div class="cta-button-dashboard">
    <i class="fas fa-plus not-circle"></i>
    <h1 class="cta-button-dashboard-head">Add new</h1>
    <p class="cta-text">Add new student info</p>
    <Link href="/add-new" class="button-1">Click here</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
.cta-button-dashboard {
  padding: 16px;
  background-color: #235F23;
  border-radius: 15px;
  margin-top: 85px;
}

.cta-button-dashboard-head {
  font-size: 14px;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 12px;
}

.cta-text {
  font-size: 12px;
  font-weight: 400;
  color: #ffffff;
  margin-bottom: 12px;
}

.cta-button-dashboard .fas.fa-plus {
  border-radius: 12px;
  font-size: 24px;
  margin-bottom: 21px;
  color: #235F23;
  background-color: #ffffff;
  padding: 12px;
}

.button-1 {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: none;
  padding: 10px 32px;
  border-radius: 12px;
  /* Enhanced styling for prominence */
  background: linear-gradient(to bottom, #ffffff 0%, #f8f8f8 100%);
  color: #235F23;
  /* Layered shadows for depth */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.8) inset,
    0 2px 6px rgba(0, 0, 0, 0.15),
    0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  cursor: pointer;
  display: inline-block;
  text-decoration: none;
}

.button-1:hover {
  background: linear-gradient(to bottom, #ffffff 0%, #f0f0f0 100%);
  color: #1a4a1a;
  /* Enhanced shadow + glow on hover */
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.9) inset,
    0 4px 12px rgba(0, 0, 0, 0.2),
    0 6px 20px rgba(35, 95, 35, 0.15),
    0 0 0 2px rgba(255, 255, 255, 0.3);
  transform: translateY(-2px) scale(1.02);
}

.button-1:active {
  transform: translateY(0) scale(0.98);
  box-shadow: 
    0 1px 0 rgba(255, 255, 255, 0.7) inset,
    0 2px 4px rgba(0, 0, 0, 0.2);
}
</style>

