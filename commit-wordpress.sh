#!/bin/bash

# ====================================================================
# WordPress Folder Commit Helper Script
# ====================================================================
# Script ini membantu commit folder WordPress secara bertahap
# untuk menghindari timeout dan error saat push ke GitHub
# ====================================================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Branch name
BRANCH="claude/setup-hostinger-github-013SNNzCiWR592WPEEBHHW9e"

# Function to print colored output
print_info() {
    echo -e "${BLUE}ℹ ${NC}$1"
}

print_success() {
    echo -e "${GREEN}✓ ${NC}$1"
}

print_warning() {
    echo -e "${YELLOW}⚠ ${NC}$1"
}

print_error() {
    echo -e "${RED}✗ ${NC}$1"
}

# Function to check folder size
check_size() {
    local folder=$1
    if [ -d "$folder" ]; then
        local size=$(du -sh "$folder" 2>/dev/null | cut -f1)
        echo "$size"
    else
        echo "N/A"
    fi
}

# Function to commit and push
commit_and_push() {
    local folder=$1
    local message=$2

    if [ ! -d "$folder" ]; then
        print_warning "Folder $folder tidak ditemukan, skip..."
        return
    fi

    print_info "Processing: $folder"

    # Check if there are changes
    if git diff --quiet "$folder" && git diff --cached --quiet "$folder"; then
        print_warning "Tidak ada perubahan di $folder, skip..."
        return
    fi

    # Add folder
    print_info "Adding $folder to staging..."
    git add "$folder"

    # Show what will be committed
    local file_count=$(git diff --cached --name-only "$folder" | wc -l)
    print_info "File yang akan di-commit: $file_count files"

    # Commit
    print_info "Creating commit..."
    git commit -m "$message"

    # Push
    print_info "Pushing to GitHub..."
    if git push -u origin "$BRANCH"; then
        print_success "✓ Successfully committed and pushed: $folder"
    else
        print_error "Failed to push $folder"
        print_warning "Mencoba retry dalam 5 detik..."
        sleep 5

        if git push -u origin "$BRANCH"; then
            print_success "✓ Retry successful!"
        else
            print_error "Retry failed. Silakan push manual dengan: git push -u origin $BRANCH"
            exit 1
        fi
    fi

    echo ""
}

# Main script
echo "=========================================="
echo "WordPress Folder Commit Helper"
echo "=========================================="
echo ""

# Check if we're in a git repository
if ! git rev-parse --git-dir > /dev/null 2>&1; then
    print_error "Bukan git repository! Jalankan script ini di dalam folder repository."
    exit 1
fi

# Check current branch
current_branch=$(git branch --show-current)
print_info "Current branch: $current_branch"

if [ "$current_branch" != "$BRANCH" ]; then
    print_warning "Anda tidak di branch $BRANCH"
    read -p "Switch ke branch $BRANCH? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git checkout "$BRANCH"
    else
        print_error "Dibatalkan."
        exit 1
    fi
fi

echo ""
print_info "Checking folder sizes..."
echo "----------------------------------------"
echo "wp-admin/          : $(check_size 'wp-admin')"
echo "wp-includes/       : $(check_size 'wp-includes')"
echo "wp-content/themes/ : $(check_size 'wp-content/themes')"
echo "wp-content/plugins/: $(check_size 'wp-content/plugins')"
echo "----------------------------------------"
echo ""

# Ask for confirmation
read -p "Lanjutkan commit bertahap? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Dibatalkan."
    exit 0
fi

echo ""
print_info "Memulai commit bertahap..."
echo ""

# Commit wp-admin
commit_and_push "wp-admin" "Add wp-admin folder (WordPress admin panel)"

# Commit wp-includes
commit_and_push "wp-includes" "Add wp-includes folder (WordPress core files)"

# Commit wp-content/themes
commit_and_push "wp-content/themes" "Add WordPress themes"

# Commit wp-content/plugins
commit_and_push "wp-content/plugins" "Add WordPress plugins"

# Commit remaining wp-content (jika ada)
if [ -d "wp-content" ]; then
    print_info "Checking for remaining wp-content files..."

    # Check if there are any unstaged changes in wp-content
    if ! git diff --quiet wp-content/ || ! git diff --cached --quiet wp-content/; then
        commit_and_push "wp-content" "Add remaining wp-content files"
    else
        print_success "No remaining wp-content files to commit"
    fi
fi

echo ""
echo "=========================================="
print_success "✓ Semua folder berhasil di-commit dan push!"
echo "=========================================="
echo ""
print_info "Next steps:"
echo "  1. Cek di GitHub: https://github.com/cupitebet/majelis.info"
echo "  2. Verify semua folder sudah ada"
echo "  3. Setup FTP secrets untuk auto-deployment"
echo ""
print_success "Done! 🚀"
