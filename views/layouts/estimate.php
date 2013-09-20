<?php 

# This layout has been deprecated. Estimates now use the detailed layout,
# in order to keep code DRY. There are very few differences between the two,
# which can be handled with a couple of 'if (type == estimate)' statements.
# No need to keep this layout around.

# We had problems with differences between the estimate view and the detailed view
# that were caused by people making changes to the detailed layout and forgetting to
# do the same in this estimate layout.

# So for the sake of DRY and easier maintainability,
# forget this layout.

# Thanks.
# - Bruno