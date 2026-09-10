/**
 * SGPayroll - Resizable & Minimizable Sidebar Controller
 * Features:
 * - Fluid drag-to-resize with min/max bounds and snap-to-collapse
 * - Smooth CSS transitions for minimize and expand
 * - Icon-only + centered logo collapsed state with floating tooltips
 * - Full state persistence across page loads via localStorage
 * - Keyboard shortcut (Ctrl+B / Cmd+B) toggle
 */

(function () {
    'use strict';

    var STORAGE_KEY_COLLAPSED = 'sgpayroll_sidebar_collapsed';
    var STORAGE_KEY_WIDTH = 'sgpayroll_sidebar_width';

    var MIN_WIDTH = 200;
    var MAX_WIDTH = 460;
    var COLLAPSED_WIDTH = 72;
    var DEFAULT_WIDTH = 256;
    var SNAP_COLLAPSE_THRESHOLD = 135;
    var SNAP_EXPAND_THRESHOLD = 145;

    function initSidebar() {
        var sidebar = document.getElementById('app-sidebar');
        var handle = document.getElementById('sidebarResizeHandle');
        var toggleBtn = document.getElementById('sidebarToggleBtn');
        var desktopToggleBtn = document.getElementById('desktopSidebarToggleBtn');
        var tooltip = document.getElementById('sidebarFloatingTooltip');
        var brandLink = document.getElementById('sidebarBrandLink');

        if (!sidebar) return;

        // Determine initial collapsed state and width
        var isInitialCollapsed = localStorage.getItem(STORAGE_KEY_COLLAPSED) === 'true';
        var savedWidth = parseInt(localStorage.getItem(STORAGE_KEY_WIDTH), 10);
        if (isNaN(savedWidth) || savedWidth < MIN_WIDTH || savedWidth > MAX_WIDTH) {
            savedWidth = DEFAULT_WIDTH;
        }

        if (isInitialCollapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
            sidebar.classList.add('sidebar-collapsed');
        } else {
            document.documentElement.classList.remove('sidebar-collapsed');
            sidebar.classList.remove('sidebar-collapsed');
            document.documentElement.style.setProperty('--sidebar-width', savedWidth + 'px');
            sidebar.style.width = savedWidth + 'px';
        }

        function isCollapsed() {
            return document.documentElement.classList.contains('sidebar-collapsed') ||
                   sidebar.classList.contains('sidebar-collapsed');
        }

        function collapseSidebar() {
            document.documentElement.classList.add('sidebar-collapsed');
            sidebar.classList.add('sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY_COLLAPSED, 'true');
            if (tooltip) tooltip.classList.remove('show');
            if (toggleBtn) toggleBtn.setAttribute('title', 'Expand sidebar (Ctrl+B)');
            if (desktopToggleBtn) desktopToggleBtn.setAttribute('title', 'Expand sidebar (Ctrl+B)');
        }

        function expandSidebar(targetWidth) {
            document.documentElement.classList.remove('sidebar-collapsed');
            sidebar.classList.remove('sidebar-collapsed');
            var width = targetWidth;
            if (!width) {
                var stored = parseInt(localStorage.getItem(STORAGE_KEY_WIDTH), 10);
                width = (!isNaN(stored) && stored >= MIN_WIDTH && stored <= MAX_WIDTH) ? stored : DEFAULT_WIDTH;
            }
            width = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, width));
            document.documentElement.style.setProperty('--sidebar-width', width + 'px');
            sidebar.style.width = width + 'px';
            localStorage.setItem(STORAGE_KEY_COLLAPSED, 'false');
            localStorage.setItem(STORAGE_KEY_WIDTH, width);
            if (tooltip) tooltip.classList.remove('show');
            if (toggleBtn) toggleBtn.setAttribute('title', 'Collapse sidebar (Ctrl+B)');
            if (desktopToggleBtn) desktopToggleBtn.setAttribute('title', 'Collapse sidebar (Ctrl+B)');
        }

        function toggleSidebar() {
            if (isCollapsed()) {
                expandSidebar();
            } else {
                collapseSidebar();
            }
        }

        // Toggle buttons click listeners
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (desktopToggleBtn) {
            desktopToggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                toggleSidebar();
            });
        }

        // Clicking brand logo while collapsed expands the sidebar
        if (brandLink) {
            brandLink.addEventListener('click', function (e) {
                if (isCollapsed()) {
                    e.preventDefault();
                    expandSidebar();
                }
            });
        }

        // Keyboard Shortcut: Ctrl + B or Cmd + B
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                var activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
                if (activeTag === 'input' || activeTag === 'textarea' || activeTag === 'select') {
                    return;
                }
                e.preventDefault();
                toggleSidebar();
            }
        });

        // -------------------------------------------------------------
        // Drag-to-Resize Mechanism
        // -------------------------------------------------------------
        if (handle) {
            var isResizing = false;
            var startX = 0;
            var startWidth = 0;

            handle.addEventListener('mousedown', function (e) {
                // Only left click
                if (e.button !== 0) return;
                e.preventDefault();

                isResizing = true;
                startX = e.clientX;
                startWidth = sidebar.getBoundingClientRect().width;

                document.body.classList.add('is-resizing');
                sidebar.classList.add('is-resizing');
                handle.classList.add('active');
            });

            document.addEventListener('mousemove', function (e) {
                if (!isResizing) return;

                var deltaX = e.clientX - startX;
                var currentWidth = startWidth + deltaX;

                if (currentWidth < SNAP_COLLAPSE_THRESHOLD) {
                    if (!isCollapsed()) {
                        document.documentElement.classList.add('sidebar-collapsed');
                        sidebar.classList.add('sidebar-collapsed');
                    }
                } else {
                    if (isCollapsed() && currentWidth >= SNAP_EXPAND_THRESHOLD) {
                        document.documentElement.classList.remove('sidebar-collapsed');
                        sidebar.classList.remove('sidebar-collapsed');
                    }

                    if (!isCollapsed()) {
                        var clampedWidth = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, currentWidth));
                        document.documentElement.style.setProperty('--sidebar-width', clampedWidth + 'px');
                        sidebar.style.width = clampedWidth + 'px';
                    }
                }
            });

            document.addEventListener('mouseup', function () {
                if (!isResizing) return;

                isResizing = false;
                document.body.classList.remove('is-resizing');
                sidebar.classList.remove('is-resizing');
                handle.classList.remove('active');

                if (isCollapsed()) {
                    localStorage.setItem(STORAGE_KEY_COLLAPSED, 'true');
                } else {
                    var finalWidth = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, Math.round(sidebar.getBoundingClientRect().width)));
                    localStorage.setItem(STORAGE_KEY_COLLAPSED, 'false');
                    localStorage.setItem(STORAGE_KEY_WIDTH, finalWidth);
                    document.documentElement.style.setProperty('--sidebar-width', finalWidth + 'px');
                    sidebar.style.width = finalWidth + 'px';
                }
            });

            // Double-click handle to reset to default 256px
            handle.addEventListener('dblclick', function () {
                expandSidebar(DEFAULT_WIDTH);
            });
        }

        // -------------------------------------------------------------
        // Floating Tooltip Positioning for Minimized Mode
        // -------------------------------------------------------------
        if (tooltip) {
            document.addEventListener('mouseover', function (e) {
                if (!isCollapsed() || window.innerWidth < 768) {
                    tooltip.classList.remove('show');
                    return;
                }

                var item = e.target.closest('.sidebar-nav-item');
                if (item) {
                    var title = item.getAttribute('data-tooltip');
                    if (!title) {
                        var labelEl = item.querySelector('.sidebar-label');
                        if (labelEl) title = labelEl.textContent.trim();
                    }

                    if (title) {
                        tooltip.textContent = title;
                        tooltip.classList.add('show');

                        var itemRect = item.getBoundingClientRect();
                        var tooltipRect = tooltip.getBoundingClientRect();
                        var top = itemRect.top + (itemRect.height - tooltipRect.height) / 2;
                        var left = itemRect.right + 10;

                        tooltip.style.top = Math.round(top) + 'px';
                        tooltip.style.left = Math.round(left) + 'px';
                    }
                }
            });

            document.addEventListener('mouseout', function (e) {
                var item = e.target.closest('.sidebar-nav-item');
                if (item) {
                    tooltip.classList.remove('show');
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
})();