pipeline {
    agent any

    environment {
        COMPOSE_PROJECT_NAME = 'travel_blog_ci2'
        COMPOSE_FILE = 'docker-compose-part2.yml'
    }

    stages {
        stage('Clean Workspace') {
            steps {
                cleanWs()
            }
        }

        stage('Clone Application Repo') {
            steps {
                git branch: 'main', url: 'https://github.com/Faiza467/travelblog.git'
            }
        }

        stage('Build and Deploy Containers') {
            steps {
                script {
                    echo "🛠️ Stopping old containers (if running)..."
                    sh "docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} down || true"

                    echo "🧱 Building containers without cache..."
                    sh "docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} build --no-cache"

                    echo "🚀 Starting containers..."
                    sh "docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} up -d --remove-orphans"
                }
            }
        }

        stage('Clone Test Cases Repo') {
            steps {
                script {
                    sh "git clone https://github.com/Faiza467/travelblog-tests.git"
                }
            }
        }

        stage('Run Selenium Tests') {
            steps {
                script {
                    echo "🧪 Running Selenium test cases using Maven..."
                    sh """
                    docker run --rm \
                      --network ${COMPOSE_PROJECT_NAME}_default \
                      -v \$PWD/travelblog-tests:/project \
                      -w /project \
                      markhobson/maven-chrome mvn test
                    """
                }
            }
        }
    }

    post {
        success {
            echo '✅ All test cases passed successfully!'
        }
        failure {
            echo '❌ Some test cases failed. Please check the Console Output and Test Report.'
        }
        always {
            echo '📦 Publishing test reports...'
            junit 'travelblog-tests/target/surefire-reports/*.xml'
        }
    }
}
