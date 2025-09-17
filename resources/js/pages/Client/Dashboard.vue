<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
          <p class="text-gray-600">Welcome back, {{ $page.props.auth.client.name }}!</p>
        </div>
        <div class="flex space-x-3">
          <Button @click="$inertia.visit(route('pages.create'))">
            <Icon name="plus" class="w-4 h-4 mr-2" />
            New Page
          </Button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <Card>
          <CardContent class="p-6">
            <div class="flex items-center">
              <div class="p-2 bg-blue-100 rounded-lg">
                <Icon name="file-text" class="w-6 h-6 text-blue-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pages</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.totalPages }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent class="p-6">
            <div class="flex items-center">
              <div class="p-2 bg-green-100 rounded-lg">
                <Icon name="eye" class="w-6 h-6 text-green-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Views</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.totalViews }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent class="p-6">
            <div class="flex items-center">
              <div class="p-2 bg-purple-100 rounded-lg">
                <Icon name="users" class="w-6 h-6 text-purple-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Unique Visitors</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.totalUniqueVisitors }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardContent class="p-6">
            <div class="flex items-center">
              <div class="p-2 bg-orange-100 rounded-lg">
                <Icon name="check-circle" class="w-6 h-6 text-orange-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Published Pages</p>
                <p class="text-2xl font-bold text-gray-900">{{ stats.publishedPages }}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Recent Pages -->
      <Card>
        <CardHeader>
          <div class="flex items-center justify-between">
            <CardTitle>Recent Pages</CardTitle>
            <Button variant="outline" @click="$inertia.visit(route('pages.index'))">
              View All
            </Button>
          </div>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div v-for="page in recentPages" :key="page.id" class="flex items-center justify-between p-4 border rounded-lg">
              <div class="flex items-center space-x-4">
                <div class="p-2 bg-gray-100 rounded-lg">
                  <Icon name="file-text" class="w-5 h-5 text-gray-600" />
                </div>
                <div>
                  <h3 class="font-medium text-gray-900">{{ page.title }}</h3>
                  <p class="text-sm text-gray-600">{{ page.slug }}</p>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <Badge :variant="page.is_published ? 'default' : 'secondary'">
                  {{ page.is_published ? 'Published' : 'Draft' }}
                </Badge>
                <Button variant="outline" size="sm" @click="$inertia.visit(route('pages.edit', page.id))">
                  Edit
                </Button>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      <!-- Quick Actions -->
      <Card>
        <CardHeader>
          <CardTitle>Quick Actions</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <Button variant="outline" class="h-20 flex flex-col items-center justify-center" @click="$inertia.visit(route('pages.create'))">
              <Icon name="plus" class="w-6 h-6 mb-2" />
              <span>Create New Page</span>
            </Button>
            <Button variant="outline" class="h-20 flex flex-col items-center justify-center" @click="$inertia.visit(route('analytics.index'))">
              <Icon name="bar-chart" class="w-6 h-6 mb-2" />
              <span>View Analytics</span>
            </Button>
            <Button variant="outline" class="h-20 flex flex-col items-center justify-center" @click="$inertia.visit(route('pages.index'))">
              <Icon name="list" class="w-6 h-6 mb-2" />
              <span>Manage Pages</span>
            </Button>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import Icon from '@/components/Icon.vue'

defineProps<{
  stats: {
    totalPages: number
    totalViews: number
    totalUniqueVisitors: number
    publishedPages: number
  }
  recentPages: Array<{
    id: number
    title: string
    slug: string
    is_published: boolean
  }>
}>()
</script>
