<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
          <p class="text-gray-600">Track your page performance and visitor insights</p>
        </div>
        <div class="flex space-x-3">
          <Select v-model="selectedPeriod" @update:model-value="updatePeriod">
            <SelectTrigger class="w-40">
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="7">Last 7 days</SelectItem>
              <SelectItem value="30">Last 30 days</SelectItem>
              <SelectItem value="90">Last 90 days</SelectItem>
            </SelectContent>
          </Select>
          <Button variant="outline" @click="exportData">
            <Icon name="download" class="w-4 h-4 mr-2" />
            Export CSV
          </Button>
        </div>
      </div>

      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <Card>
          <CardContent class="p-6">
            <div class="flex items-center">
              <div class="p-2 bg-blue-100 rounded-lg">
                <Icon name="eye" class="w-6 h-6 text-blue-600" />
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
              <div class="p-2 bg-green-100 rounded-lg">
                <Icon name="users" class="w-6 h-6 text-green-600" />
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
              <div class="p-2 bg-purple-100 rounded-lg">
                <Icon name="file-text" class="w-6 h-6 text-purple-600" />
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

      <!-- Charts -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Page Views Chart -->
        <Card>
          <CardHeader>
            <CardTitle>Page Views Over Time</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="h-64 flex items-center justify-center">
              <div class="text-center">
                <Icon name="bar-chart" class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                <p class="text-gray-500">Chart visualization would go here</p>
                <p class="text-sm text-gray-400">{{ pageViews.length }} data points</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Unique Visitors Chart -->
        <Card>
          <CardHeader>
            <CardTitle>Unique Visitors Over Time</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="h-64 flex items-center justify-center">
              <div class="text-center">
                <Icon name="trending-up" class="w-12 h-12 text-gray-400 mx-auto mb-2" />
                <p class="text-gray-500">Chart visualization would go here</p>
                <p class="text-sm text-gray-400">{{ uniqueVisitors.length }} data points</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Top Pages -->
      <Card>
        <CardHeader>
          <CardTitle>Top Performing Pages</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="space-y-4">
            <div v-for="(page, index) in topPages" :key="page.id" class="flex items-center justify-between p-4 border rounded-lg">
              <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                  <span class="text-sm font-medium text-gray-600">{{ index + 1 }}</span>
                </div>
                <div>
                  <h3 class="font-medium text-gray-900">{{ page.title }}</h3>
                  <p class="text-sm text-gray-600">{{ page.slug }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-lg font-bold text-gray-900">{{ page.analytics_count }}</p>
                <p class="text-sm text-gray-600">views</p>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  pageViews: Array<{
    date: string
    views: number
  }>
  uniqueVisitors: Array<{
    date: string
    unique_visitors: number
  }>
  topPages: Array<{
    id: number
    title: string
    slug: string
    analytics_count: number
  }>
  stats: {
    totalViews: number
    totalUniqueVisitors: number
    totalPages: number
    publishedPages: number
  }
  period: string
}>()

const selectedPeriod = ref(props.period)

const updatePeriod = (period: string) => {
  // Implementation for updating period
  console.log('Updating period to:', period)
}

const exportData = () => {
  // Implementation for CSV export
  console.log('Exporting data')
}
</script>
