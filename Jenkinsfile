stage('Deploy in Test env') {
    when {
        branch 'staging'
    }
    steps {
        sh "./deploy-staging.sh"
    }
}

stage('Deploy in Prod env') {
    when {
        branch 'master'
    }
    steps {
        // sh "./deploy.sh"
    }
}