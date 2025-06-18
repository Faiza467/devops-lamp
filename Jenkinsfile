pipeline {
    agent any

    stages {
        stage('Clone Main Repo') {
            steps {
                git branch: 'main', url: 'https://github.com/Faiza467/devops-lamp.git'
            }
        }

        stage('Build and Deploy Containers') {
            steps {
                script {
                    sh 'docker-compose -p travel_blog_ci2 -f docker-compose-part2.yml down || true'
                    sh 'docker-compose -p travel_blog_ci2 -f docker-compose-part2.yml build --no-cache'
                    sh 'docker-compose -p travel_blog_ci2 -f docker-compose-part2.yml up -d --remove-orphans'
                }
            }
        }

        stage('Clone Test Repo') {
            steps {
                sh 'git clone https://github.com/Faiza467/travelblog-tests.git'
            }
        }

        stage('Run Selenium Tests (Headless Chrome)') {
            agent {
                docker {
                    image 'markhobson/maven-chrome'
                    args '-v /dev/shm:/dev/shm'
                }
            }
            steps {
                dir('travelblog-tests') {
                    sh 'mvn clean test'
                }
            }
        }

        stage('Teardown Containers') {
            steps {
                script {
                    sh 'docker-compose -p travel_blog_ci2 -f docker-compose-part2.yml down'
                }
            }
        }
    }
}
