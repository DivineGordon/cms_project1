<template>
  <AuthLayout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Sign in to your account
          </h2>
          <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <Link :href="route('client.register')" class="font-medium text-indigo-600 hover:text-indigo-500">
              create a new account
            </Link>
          </p>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="rounded-md shadow-sm -space-y-px">
            <div>
              <Label for="email" class="sr-only">Email address</Label>
              <Input
                id="email"
                v-model="form.email"
                type="email"
                autocomplete="email"
                required
                class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                placeholder="Email address"
              />
            </div>
            <div>
              <Label for="password" class="sr-only">Password</Label>
              <Input
                id="password"
                v-model="form.password"
                type="password"
                autocomplete="current-password"
                required
                class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                placeholder="Password"
              />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <Checkbox
                id="remember"
                v-model:checked="form.remember"
                name="remember"
              />
              <Label for="remember" class="ml-2 block text-sm text-gray-900">
                Remember me
              </Label>
            </div>

            <div class="text-sm">
              <Link :href="route('password.request')" class="font-medium text-indigo-600 hover:text-indigo-500">
                Forgot your password?
              </Link>
            </div>
          </div>

          <div>
            <Button
              type="submit"
              :disabled="form.processing"
              class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <Icon name="lock" class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" />
              </span>
              {{ form.processing ? 'Signing in...' : 'Sign in' }}
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'
import Icon from '@/components/Icon.vue'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('client.login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>
