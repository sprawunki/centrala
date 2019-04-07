pipeline {
    agent none

    stages {
        stage("build") {
            agent any

            steps {
                sh "docker build --target dev -t macieklewkowicz/centrala:dev ."
            }
        }
        stage("verify") {
            parallel {
                stage("analyze") {
                    agent {
                        docker {
                            image "macieklewkowicz/centrala:dev"
                        }
                    }

                    steps {
                        sh "make analyze"
                    }
                }

                stage("test") {
                    agent {
                        docker {
                            image "macieklewkowicz/centrala:dev"
                        }
                    }

                    steps {
                        sh "make test"
                    }
                }
            }
        }
    }
}
