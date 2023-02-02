
    <?php if ( !$userModel) : ?>
        <div>
            Unauthorize
        </div>
    <!-- HTML code here -->
    <?php endif; ?>
    <?php if ( $userModel) : ?>
        <button>
        <a href="/PHPMVCFramework/src/logout">Log out</a>
        </button>
    <!-- HTML code here -->
    <?php endif; ?>

    

