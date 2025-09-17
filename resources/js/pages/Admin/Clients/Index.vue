<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Client Management</h1>
          <p class="text-gray-600">Manage your CMS clients</p>
        </div>
        <Button @click="$inertia.visit(route('clients.create'))">
          <Icon name="plus" class="w-4 h-4 mr-2" />
          Add Client
        </Button>
      </div>

      <!-- Clients Table -->
      <Card>
        <CardContent class="p-0">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="border-b">
                <tr>
                  <th class="text-left p-4 font-medium text-gray-900">Name</th>
                  <th class="text-left p-4 font-medium text-gray-900">Email</th>
                  <th class="text-left p-4 font-medium text-gray-900">Company</th>
                  <th class="text-left p-4 font-medium text-gray-900">Slug</th>
                  <th class="text-left p-4 font-medium text-gray-900">Status</th>
                  <th class="text-left p-4 font-medium text-gray-900">Pages</th>
                  <th class="text-left p-4 font-medium text-gray-900">Created</th>
                  <th class="text-right p-4 font-medium text-gray-900">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="client in clients.data" :key="client.id" class="border-b hover:bg-gray-50">
                  <td class="p-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-600">
                          {{ client.name.charAt(0).toUpperCase() }}
                        </span>
                      </div>
                      <div>
                        <h3 class="font-medium text-gray-900">{{ client.name }}</h3>
                      </div>
                    </div>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ client.email }}</span>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ client.company_name || '-' }}</span>
                  </td>
                  <td class="p-4">
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ client.slug }}</code>
                  </td>
                  <td class="p-4">
                    <Badge :variant="client.is_active ? 'default' : 'secondary'">
                      {{ client.is_active ? 'Active' : 'Inactive' }}
                    </Badge>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ client.pages_count || 0 }}</span>
                  </td>
                  <td class="p-4">
                    <span class="text-sm text-gray-600">{{ formatDate(client.created_at) }}</span>
                  </td>
                  <td class="p-4">
                    <div class="flex items-center justify-end space-x-2">
                      <Button
                        variant="outline"
                        size="sm"
                        @click="$inertia.visit(route('clients.show', client.id))"
                      >
                        View
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        @click="$inertia.visit(route('clients.edit', client.id))"
                      >
                        Edit
                      </Button>
                      <Button
                        variant="outline"
                        size="sm"
                        @click="deleteClient(client)"
                      >
                        Delete
                      </Button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      <!-- Pagination -->
      <div v-if="clients.links" class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
          Showing {{ clients.from }} to {{ clients.to }} of {{ clients.total }} results
        </div>
        <div class="flex space-x-2">
          <Button
            v-for="link in clients.links"
            :key="link.label"
            variant="outline"
            size="sm"
            :disabled="!link.url"
            @click="link.url && $inertia.visit(link.url)"
            v-html="link.label"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  clients: {
    data: Array<{
      id: number
      name: string
      email: string
      company_name: string | null
      slug: string
      is_active: boolean
      pages_count: number
      created_at: string
    }>
    links: Array<{
      label: string
      url: string | null
    }>
    from: number
    to: number
    total: number
  }
}>()

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString()
}

const deleteClient = (client: any) => {
  if (confirm(`Are you sure you want to delete ${client.name}?`)) {
    // Implementation for delete client
    console.log('Delete client:', client.id)
  }
}
</script>
