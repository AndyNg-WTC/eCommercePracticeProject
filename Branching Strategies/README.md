# Ecommerce Practice Project Branch Strategy

Within the Ecommerce Practice Project Repository, there are three branches: 

## Main

The `main` branch will contain stable code which can be deployed to users at any time. In cases where an urgent hotfix is required, a hotfix branch can be 

## UAT

The `UAT` branch will be usually ahead of the main branch as it will contain the updated code from the dev branch. This branch will be used for QAs to test out the code before it is merged with the main branch.
If a hotfix is required, then a hotfix branch will be created from this branch. The developers can then work on the hotfix code and then commit the new changes to the hotfix branch before merging back to the UAT branch. 

## Dev

The dev branch will contain the latest code. Developers will not be directly working on the dev branch, but they will create a feature/bug fix branches (sub-branches) from dev where they will then commit their code to. Only code that have passed unit testing from the feature/bug branch will then be merged into the dev and UAT branch.


