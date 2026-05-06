pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                echo 'Mengambil source code dari GitHub...'
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Membuat Docker image Laravel...'
                sh 'docker build -t sasimga-laravel:latest .'
            }
        }

        stage('Deploy to Docker Swarm') {
            steps {
                echo 'Deploy aplikasi ke Docker Swarm...'
                sh 'docker stack deploy -c docker-compose.yml sasimga'
            }
        }

        stage('Check Service') {
            steps {
                echo 'Mengecek service Docker Swarm...'
                sh 'docker service ls'
            }
        }
    }
}
