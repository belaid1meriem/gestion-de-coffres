<script setup lang="ts">
import Input from './ui/Input.vue';
import ButtonPrimary from './ui/ButtonPrimary.vue';
import useAddFriendForm from '@/composables/forms/useAddFriendForm';
import { watch } from 'vue';
import { toast } from 'vue-sonner';

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
    success,
    isLoading,
    onSubmit
  } = useAddFriendForm()

watch(success,()=>{
    if(success){
        toast.success(success)
    }
})
</script>
<template>
        <form @submit="onSubmit">
            <div class="flex flex-col gap-8">
                <!-- welcome text -->
                <div class="flex flex-col items-center gap-2">
                    <h1 class="text-xl font-semibold">Fill the form with your friend's informations</h1>
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

                    <ButtonPrimary :text="isLoading ? 'Loading...' : 'Add a friend'" class="w-full px-2" :disabled="isLoading"/>
                </div>

            </div>
        </form> 
</template>