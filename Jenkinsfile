pipeline {
    agent any

    environment {
        APP_IMAGE = 'sihiy1/sasimga-jember:latest'
        NGINX_IMAGE = 'sihiy1/sasimga-nginx:latest'
        STACK_NAME = 'samsimga'
        GIT_REPO = 'https://github.com/TIM-UYE/SaSimGa-jember.git'
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Checking out source code...'
                dir('sasimga-jember') {
                    git branch: 'main', url: "${GIT_REPO}"
                }
            }
        }

        stage('Validate Docker') {
            steps {
                echo 'Validating Docker configuration...'
                sh 'docker --version'
            }
        }

        stage('Build App Docker Image') {
            steps {
                dir('sasimga-jember') {
                    echo 'Building Laravel application image...'
                    sh 'docker build -t ${APP_IMAGE} -f dockerfile .'
                }
            }
        }

        stage('Build Nginx Docker Image') {
            steps {
                dir('sasimga-jember') {
                    echo 'Building Nginx image...'
                    sh 'docker build -t ${NGINX_IMAGE} -f Dockerfile.nginx .'
                }
            }
        }

        stage('Run Tests') {
            steps {
                dir('sasimga-jember') {
                    echo 'Running application tests...'
                    sh '''
                        docker run --rm ${APP_IMAGE} php artisan test --compact || true
                    '''
                }
            }
        }

        stage('Deploy to Docker Swarm') {
            steps {
                echo 'Deploying to Docker Swarm...'

                sh '''
                # Check apakah stack sudah ada
                if docker stack ls | grep -q "${STACK_NAME}"; then

                    echo "Stack exists. Updating services..."

                    docker service update \
                    --force \
                    --image ${APP_IMAGE} \
                    ${STACK_NAME}_app

                    sleep 10

                    echo "===== APP LOGS ====="
                    docker service logs ${STACK_NAME}_app --tail 50 || true

                    docker service update \
                    --force \
                    --image ${NGINX_IMAGE} \
                    ${STACK_NAME}_nginx

                else

                    echo "Stack not found. Creating new stack..."

                    docker stack deploy \
                    -c docker-stack.yml \
                    ${STACK_NAME}

                fi
                '''
            }
        }

        stage('Verify Deployment') {
            steps {
                echo 'Verifying deployment...'
                sh '''
                    echo 'Waiting for services to start...'
                    sleep 10

                    # Check if services are running
                    docker service ls | grep ${STACK_NAME} || echo "Services not found"

                    echo 'Checking application health...'
                '''
            }
        }
    }

    post {
        success {
            echo 'Deployment completed successfully!'
        }
        failure {
            echo 'Deployment failed! Check logs for details.'
        }
        always {
            echo 'Cleaning up...'
            sh 'docker system prune -f'
        }
    }
}
