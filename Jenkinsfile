pipeline {
    agent any

    stages {
        stage('Clone Application Repo') {
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

        stage('Clone Test Cases Repo') {
            steps {
                script {
                    sh 'rm -rf travelblog-tests' 
                    sh 'git clone https://github.com/Faiza467/travelblog-tests.git'
                }
            }
        }

        stage('Run Test Cases') {
            steps {
                script {
                    sh '''
                    docker run --rm \
                        -v "$PWD":/tests \
                        -w /tests \
                        markhobson/maven-chrome \
                        mvn -f travelblog-tests/pom.xml test
                    '''
                }
            }
        }
    }
}
