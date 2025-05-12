pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                git 'https://github.com/Faiza467/my-lamp-app.git'
            }
        }

        stage('Build and Deploy Containers') {
            steps {
                script {
                    // Stop any running containers to avoid conflicts
                    sh 'docker compose -f docker-compose-part2.yml down'
                    // Build and start the containers
                    sh 'docker compose -f docker-compose-part2.yml up -d --build'
                }
            }
        }
    }
}
