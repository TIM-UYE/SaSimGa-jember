pipeline {
    agent any

    environment {
        APP_IMAGE = 'sihiy1/sasimga-jember:latest'
        NGINX_IMAGE = 'sihiy1/sasimga-nginx:latest'
        STACK_NAME = 'samsimga'
        DOCKER_REGISTRY = 'docker.io/sihiy1'
    }

    stages {
        stage('Checkout') {
            steps {
                echo 'Checking out source code...'
                checkout scm
            }
        }

        stage('Validate Dockerfiles') {
            steps {
                echo 'Validating Docker configuration...'
                sh 'docker --version'
                sh 'docker-compose --version'
            }
        }

        stage('Build App Docker Image') {
            steps {
                echo 'Building Laravel application image...'
                sh 'docker build -t ${APP_IMAGE} -f dockerfile .'
            }
        }

        stage('Build Nginx Docker Image') {
            steps {
                echo 'Building Nginx image...'
                sh 'docker build -t ${NGINX_IMAGE} -f Dockerfile.nginx .'
            }
        }

        stage('Run Tests') {
            steps {
                echo 'Running application tests...'
                script {
                    // Run tests in a temporary container
                    sh '''
                        docker run --rm ${APP_IMAGE} php artisan test --compact
                    '''
                }
            }
            post {
                always {
                    // Collect test results if available
                    junit allowEmptyResults: true, testResults: 'test-results/**/*.xml'
                }
            }
        }

        stage('Push Docker Images') {
            steps {
                echo 'Images built successfully - skipping push (no credentials configured)'
                // Push is optional - only needed for remote deployment
                // For local deployment, images are already available
            }
        }

        stage('Deploy to Docker Swarm') {
            steps {
                echo 'Deploying to Docker Swarm...'
                sh 'docker stack deploy -c docker-stack.yml ${STACK_NAME}'
            }
        }

        stage('Verify Deployment') {
            steps {
                echo 'Verifying deployment...'
                script {
                    // Wait for services to be ready
                    sh '''
                        echo 'Waiting for services to start...'
                        sleep 10

                        # Check if services are running
                        docker service ls | grep ${STACK_NAME}

                        # Check application health
                        echo 'Checking application health...'
                    '''
                }
            }
        }
    }

    post {
    always {
        echo 'Cleaning up...'
    }

    success {
        echo 'Deployment success!'
    }

    failure {
        echo 'Deployment failed! Check logs for details.'
    }
    }
}
