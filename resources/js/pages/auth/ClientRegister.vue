<template>
  <AuthLayout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Create your account
          </h2>
          <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <Link :href="route('client.login')" class="font-medium text-indigo-600 hover:text-indigo-500">
              sign in to your existing account
            </Link>
          </p>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="space-y-4">
            <div>
              <Label for="name">Full Name</Label>
              <Input
                id="name"
                v-model="form.name"
                type="text"
                required
                autocomplete="name"
                placeholder="Enter your full name"
              />
              <InputError :message="form.errors.name" />
            </div>

            <div>
              <Label for="email">Email Address</Label>
              <Input
                id="email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                placeholder="Enter your email"
              />
              <InputError :message="form.errors.email" />
            </div>

            <div>
              <Label for="slug">Website Slug</Label>
              <Input
                id="slug"
                v-model="form.slug"
                type="text"
                required
                placeholder="your-website-slug"
              />
              <p class="text-sm text-gray-500 mt-1">
                This will be your website URL: yoursite.com/page/{slug}
              </p>
              <InputError :message="form.errors.slug" />
            </div>

            <div>
              <Label for="company_name">Company Name (Optional)</Label>
              <Input
                id="company_name"
                v-model="form.company_name"
                type="text"
                placeholder="Enter your company name"
              />
            </div>

            <div>
              <Label for="password">Password</Label>
              <Input
                id="password"
                v-model="form.password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Create a password"
              />
              <InputError :message="form.errors.password" />
            </div>

            <div>
              <Label for="password_confirmation">Confirm Password</Label>
              <Input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Confirm your password"
              />
              <InputError :message="form.errors.password_confirmation" />
            </div>
          </div>

          <div>
            <Button
              type="submit"
              :disabled="form.processing"
              class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <Icon name="user-plus" class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" />
              </span>
              {{ form.processing ? 'Creating account...' : 'Create account' }}
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import Icon from '@/components/Icon.vue'

const form = useForm({
  name: '',
  email: '',
  slug: '',
  company_name: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('client.register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>
