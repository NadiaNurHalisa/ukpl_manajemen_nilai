# Load Testing Implementation Script
# K6 Load Testing for Student Grade Management System

import http from 'k6/http';
import { check, group, sleep } from 'k6';
import { Rate } from 'k6/metrics';

// Custom metrics
export let errorRate = new Rate('errors');

// Test configuration for different load scenarios
export let options = {
  scenarios: {
    // Normal Load Testing
    normal_load: {
      executor: 'constant-vus',
      vus: 10,
      duration: '5m',
      tags: { test_type: 'normal_load' },
    },
    // Moderate Load Testing
    moderate_load: {
      executor: 'ramping-vus',
      startVUs: 0,
      stages: [
        { duration: '2m', target: 20 },
        { duration: '5m', target: 50 },
        { duration: '2m', target: 0 },
      ],
      tags: { test_type: 'moderate_load' },
    },
    // Stress Testing
    stress_test: {
      executor: 'ramping-vus',
      startVUs: 0,
      stages: [
        { duration: '2m', target: 50 },
        { duration: '5m', target: 100 },
        { duration: '3m', target: 150 },
        { duration: '2m', target: 0 },
      ],
      tags: { test_type: 'stress_test' },
    },
  },
  thresholds: {
    http_req_duration: ['p(95)<2000'], // 95% of requests must complete below 2s
    http_req_failed: ['rate<0.1'],     // Error rate must be below 10%
    errors: ['rate<0.1'],
  },
};

const BASE_URL = 'http://localhost/tugas_ukpl';

// Test data
const testUsers = [
  { username: 'teacher1', password: 'password123' },
  { username: 'teacher2', password: 'password456' },
];

export default function() {
  let response;
  const user = testUsers[Math.floor(Math.random() * testUsers.length)];

  group('Authentication Flow', function() {
    // Login test
    response = http.post(`${BASE_URL}/index.php`, {
      username: user.username,
      password: user.password,
    });
    
    check(response, {
      'login status is 200 or 302': (r) => r.status === 200 || r.status === 302,
      'login response time < 1000ms': (r) => r.timings.duration < 1000,
    }) || errorRate.add(1);

    sleep(1);
  });

  group('CRUD Operations', function() {
    // Test class operations
    response = http.get(`${BASE_URL}/classes.php`);
    check(response, {
      'classes page loads': (r) => r.status === 200,
      'classes response time < 500ms': (r) => r.timings.duration < 500,
    }) || errorRate.add(1);

    // Test student operations
    response = http.get(`${BASE_URL}/students.php`);
    check(response, {
      'students page loads': (r) => r.status === 200,
      'students response time < 500ms': (r) => r.timings.duration < 500,
    }) || errorRate.add(1);

    // Test grade operations
    response = http.get(`${BASE_URL}/grades.php`);
    check(response, {
      'grades page loads': (r) => r.status === 200,
      'grades response time < 500ms': (r) => r.timings.duration < 500,
    }) || errorRate.add(1);

    sleep(2);
  });

  group('Database Operations', function() {
    // Simulate database-heavy operations
    response = http.post(`${BASE_URL}/classes.php`, {
      action: 'add',
      name: `Test Class ${__VU}-${__ITER}`,
      description: 'Load test class',
    });
    
    check(response, {
      'class creation response': (r) => r.status === 200 || r.status === 302,
      'db operation time < 1500ms': (r) => r.timings.duration < 1500,
    }) || errorRate.add(1);

    sleep(1);
  });
}

export function handleSummary(data) {
  return {
    'load_test_results.json': JSON.stringify(data, null, 2),
    stdout: `
=== K6 Load Testing Results Summary ===

Scenarios Executed:
- Normal Load (10 VUs for 5min)
- Moderate Load (ramp to 50 VUs)  
- Stress Test (ramp to 150 VUs)

Key Metrics:
- Average Response Time: ${data.metrics.http_req_duration.values.avg.toFixed(2)}ms
- 95th Percentile: ${data.metrics.http_req_duration.values['p(95)'].toFixed(2)}ms
- Error Rate: ${(data.metrics.http_req_failed.values.rate * 100).toFixed(2)}%
- Total Requests: ${data.metrics.http_reqs.values.count}

Performance Status: ${data.metrics.http_req_duration.values['p(95)'] < 2000 ? 'PASS ✅' : 'FAIL ❌'}
Error Rate Status: ${data.metrics.http_req_failed.values.rate < 0.1 ? 'PASS ✅' : 'FAIL ❌'}

Recommendations:
${data.metrics.http_req_duration.values['p(95)'] > 1000 ? '- Consider database optimization' : '- Performance is acceptable'}
${data.metrics.http_req_failed.values.rate > 0.05 ? '- Investigate error causes' : '- Error rate is within acceptable range'}
`,
  };
}
