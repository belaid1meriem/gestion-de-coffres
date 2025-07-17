<script setup lang="ts">
import { RouterLink } from 'vue-router';
import Input from './ui/Input.vue';
import ButtonPrimary from './ui/ButtonPrimary.vue';
import useLoginForm from '@/composables/forms/useLoginForm';

const { 
    email,
    password,
    emailError,
    passwordError,
    error,
    isLoading,
    onSubmit
  } = useLoginForm()

</script>
<template>
    <div class="flex flex-col gap-8">
        <form @submit="onSubmit">
            <div class="flex flex-col gap-6">
                <!-- welcome text -->
                <div class="flex flex-col items-center gap-2">
                    <h1 class="text-2xl font-bold">Welcome to <span class="text-[#6C3EF5]">VaultManager</span></h1>
                    <div class="text-center text-sm">
                        Dont have an account?
                        <RouterLink to="/signup" class="underline underline-offset-4" >Sign up</RouterLink>
                    </div>

                </div>

                <!-- form fields -->
                <div class="flex flex-col gap-6">
                    <Input v-model="email" :error="emailError" label="Email" placeholder="example@mail.com" />
                    <Input v-model="password" :error="passwordError" label="Password" placeholder="password" type="password" />

                    <!-- Error -->
                    <p v-if="error" class="text-[#F44336] text-sm">{{ error }}</p>

                    <ButtonPrimary :text="isLoading ? 'Loading...' : 'Login'" class="w-full px-2" :disabled="isLoading"/>
                </div>

            </div>
        </form>
        <div class="text-[#7C7C7C] *:[a]:hover:text-primary text-center text-xs text-balance *:[a]:underline *:[a]:underline-offset-4">By clicking continue, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</div>
    </div>    
</template>