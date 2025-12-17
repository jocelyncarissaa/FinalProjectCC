import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  stages: [
    { duration: '30s', target: 1000 },  // Naik cepat ke 1000 user
    { duration: '10m', target: 1000 },  // TAHAN 1000 user selama 10 MENIT!
    { duration: '30s', target: 0 },    // Turun
  ],
};

export default function () {
  // Ganti dengan Link ALB Anda
  http.get('http://pharma-alb-699345372.us-east-1.elb.amazonaws.com/');
  sleep(1);
}