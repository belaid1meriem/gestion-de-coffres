<script setup lang="ts">
import { RouterLink } from 'vue-router';
import Input from './ui/Input.vue';
import ButtonPrimary from './ui/ButtonPrimary.vue';
import useSignupForm from '@/composables/forms/useSignupForm';

const { 
    email,
    password,
    emailError,
    passwordError,
    lastName,
    lastNameError,
    firstName,
    firstNameError,
    error,
    isLoading,
    onSubmit
  } = useSignupForm()

</script>
<template>
    <div class="flex flex-col gap-8">
        <form @submit="onSubmit">
            <div class="flex flex-col gap-6">
                <!-- welcome text -->
                <div class="flex flex-col items-center gap-2">
                    <h1 class="text-2xl font-bold">Welcome to <span class="text-[#6C3EF5]">VaultManager</span></h1>
                    <div class="text-center text-sm">
                        Already have an account?
                        <RouterLink to="/login" class="underline underline-offset-4" >Log in</RouterLink>
                    </div>

                </div>

                <!-- form fields -->
                <div class="flex flex-col gap-6">
                    <Input v-model="email" :error="emailError" label="Email" placeholder="example@mail.com" />
                    <div class="flex items-center justify-center gap-2">
                        <Input v-model="firstName" :error="firstNameError" label="First name" placeholder="John" />
                        <Input v-model="lastName" :error="lastNameError" label="Last name" placeholder="Doe" />
                    </div>
                    <Input v-model="password" :error="passwordError" label="Password" placeholder="password" type="password" />
                    <!-- Error -->
                    <p v-if="error" class="text-[#F44336] text-sm">{{ error }}</p>

                    <ButtonPrimary :text="isLoading ? 'Loading...' : 'Sign up'" class="w-full px-2" :disabled="isLoading"/>
                </div>

            </div>
        </form>
        <div class="text-[#7C7C7C] *:[a]:hover:text-primary text-center text-xs text-balance *:[a]:underline *:[a]:underline-offset-4">By clicking continue, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</div>
    </div>    
</template>